<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class Filebrowser extends Controller
{

    private $Disk;
    public function __construct()
    {

        
        $this->Disk = Storage::build([
            'driver' => 'local',
            'root' => Settings::where([["Key", "=", "MCLocation"]])->first()["Value"],
        ]);
    }

    public function index()
    {
        Session::put("FBP", "/");
        return $this->LS(Session::get("FBP"));
    }

    public function fetch(Request $Request)
    {
        $this->CHDIR($Request["cd"]);
        return view("body/snippets/snip-files", [
            "DirContent" => $this->LS(Session::get("FBP"))
        ]);
    }

    public function CHDIR($Path)
    {
        if ($Path == "..") {
            $FBP = explode("/", Session::get("FBP"));
            array_pop($FBP);
            $FBP = implode("/", $FBP);
            Session::put("FBP", !empty($FBP) ? $FBP : "/");
        } elseif ($Path == "/") {
            Session::put("FBP", "/");
        } else {
            $FBP = Session::get("FBP");
            Session::put("FBP", $FBP == "/" ? "/$Path" : "$FBP/$Path");
        }
    }

    public function downloadFile(Request $Request)
    {
        return $this->Disk->download(Session::get("FBP") . "/" . $Request["FileName"],$Request["FileName"] );
    }


    public function createFile()
    {

    }

    public function uploadFiles(Request $Request)
    {
        //dd($Request);
        /*$Request->validate([
            'files.*' => 'required|file', 
        ]);*/
        $Path = !(str_ends_with($Request->input("Path"), "/")) ? $Request->input("Path") : $Request->input("Path") . "/";
        foreach($Request->file("files") as $File)
        {
            $FileName = $File->getClientOriginalName();
            $TempFileName = $this->Disk->putFile($Path, $File);
            $this->Disk->move($Path.$TempFileName, $Path.$FileName);
        }
        return view("body/snippets/snip-files", [
            "DirContent" => $this->LS(Session::get("FBP"))
        ]);
    }

    public function showFile(Request $Request)
    {
        try {
            if ($this->Disk->exists(Session::get("FBP") . "/" . $Request["FileName"])) {
                return array("content" => base64_encode($this->Disk->get(Session::get("FBP") . "/" . $Request["FileName"])), "ext" => $this->GetAceExt($Request["FileName"]));
            }
            return "Operation cannot been executed!\nFile doesn't exist!";
        } catch (\Exception | \InvalidArgumentException) {
            return abort( 500, "Operation cannot been executed!\nFile cannot be opened!");
        }
    }

    public function saveFile(Request $Request)
    {

        return $this->Disk->put(Session::get("FBP") . "/" . $Request["FileName"], $Request["Content"] ?? "") ?
            "<div class='alert alert-success'>File has been saved succesfully!</div>"
            : "<div class='alert alert-danger'>Error file has not been saved!</div>";
    }

    public function destroy(Request $Request)
    {
        if ($this->Disk->exists(Session::get("FBP") . "/" . $Request["file"])) {
            $this->Disk->delete(Session::get("FBP") . "/" . $Request["file"]);
            return view("body/snippets/snip-files", [
                "DirContent" => $this->LS(Session::get("FBP"))
            ]);
        }
        return "Operation cannot been executed!\nFile doesn't exist!";
    }

    public function rename(Request $Request)
    {
        if ($this->Disk->exists(Session::get("FBP") . "/" . $Request["NewName"])) {
            return "Operation cannot been executed!\Destination file already exist!";
        }
        if ($this->Disk->exists(Session::get("FBP") . "/" . $Request["OldName"])) {
            $this->Disk->move(Session::get("FBP") . "/" . $Request["OldName"], Session::get("FBP") . "/" . $Request["NewName"]);
            return view("body/snippets/snip-files", [
                "DirContent" => $this->LS(Session::get("FBP"))
            ]);
        }
        return "Operation cannot been executed!\n Source file doesn't exist!";
    }

    public function duplicate(Request $Request)
    {
        if ($this->Disk->exists(Session::get("FBP") . "/" . $Request["NewName"])) {
            return "Operation cannot been executed!\nDestination file already exist!";
        }
        if ($this->Disk->exists(Session::get("FBP") . "/" . $Request["file"])) {
            $this->Disk->copy(Session::get("FBP") . "/" . $Request["OldName"], Session::get("FBP") . "/" . $Request["NewName"]);
            return view("body/snippets/snip-files", [
                "DirContent" => $this->LS(Session::get("FBP"))
            ]);
        }
        return "Operation cannot been executed!\n Source file doesn't exist!";
    }

    private function LS($Path = "/")
    {
        return [
            "Files" =>
            collect($this->Disk->Files($Path))->transform(function ($FileName) {
                return [
                    basename($FileName) => [
                        "Extension" => pathinfo($FileName, PATHINFO_EXTENSION),
                        "ExtShort" => substr(pathinfo($FileName, PATHINFO_EXTENSION), 0, 4),
                        "ModifyDate" => date("Y-m-d H:i:s", filemtime($this->Disk->path($FileName))),
                        "CreateDate" => date("Y-m-d H:i:s", filectime($this->Disk->path($FileName))),
                        "Size" => $this->HumanFileSizes(File::size($this->Disk->path($FileName)))
                    ]
                ];
            })->toArray(),
            "Directories" => collect($this->Disk->directories($Path))->transform(function ($DirName) {
                return basename($DirName);
            })->toArray(),
            "Path" => $Path
        ];
    }

    private function GetAceExt($FileName)
    {
        switch (strtolower(pathinfo($FileName, PATHINFO_EXTENSION))) {
            case "txt":
                return "text";

            case "json":
                return "json";

            case "yml":
                return "yaml";

            case "yaml":
                return "yaml";

            case "sh":
                return "sh";

            case "py":
                return "python";

            case "properties":
                return "properties";

            case "js":
                return "javascript";
            
            case "java":
                return "java";
            
            case "class":
                return "java";

            case "html":
                return "html";

            case "config":
                return "properties";

            case "css":
                return "css";

            case "md":
                return "markdown";

            case "markdown":
                return "markdown";

            default:
                return "text";
        }
    }

    private function HumanFileSizes($Bytes, $Dec = 2)
    {
        $SizeSelector = ' KMGTP';
        $Factor = floor((strlen($Bytes) - 1) / 3);
        return sprintf("%.{$Dec}f ", $Bytes / pow(1024, $Factor)) . @$SizeSelector[$Factor] . "B";
    }
}
