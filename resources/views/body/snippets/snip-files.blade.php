<div class="alert alert-outline">Current path: <div style="display: inline;" id="FilePath">{{ $DirContent['Path'] }}</div> <div class="float-right">
        {{-- <form method="put" action="{{ route('filebrowser.uploadFiles') }}">
            <input type="file" name="Files[]" id="" />
            <button class="btn btn-primary btn-sm" type="submit">upload</button>
            </form> --}}
    </div>
</div>
<table class="table table-hover table-dark fluid w-100 text-light">
    <thead>
        <tr>
            <th>
                Icon
            </th>
            <th>
                FileName
            </th>
            <th>
                Last Modified
            </th>
            <th>
                Creation Date
            </th>
            <th>
                Size
            </th>
            <th>
                Options
            </th>
        </tr>
    </thead>
    @if ($DirContent['Path'] != '/')
        <tr oncontextmenu="return false;" ondblclick="ChangeDirectory('/')">
            <td>
                <div class="folder text-center">
                    <i class="fas fa-home"></i>
                </div>
            </td>
            <td colspan="5">/&nbsp;&nbsp;(Home)</td>
        </tr>
        <tr oncontextmenu="return false;" ondblclick="ChangeDirectory('..')">
            <td>
                <div class="folder  text-center">
                    <i class="fas fa-arrow-up"></i>
                </div>
            </td>
            <td colspan="5">..&nbsp;&nbsp;(Previous folder)</td>
        </tr>
    @endif

    @foreach ($DirContent['Directories'] as $Dir)
        <tr oncontextmenu="return false;" ondblclick="ChangeDirectory('{{ $Dir }}')">
            <td>
                <div class="folder"></div>
            </td>
            <td colspan="5">{{ $Dir }}</td>
        </tr>
    @endforeach
    @foreach ($DirContent['Files'] as $File)
        @foreach ($File as $FileName => $FileInfo)
            <tr oncontextmenu="return false;" ondblclick="OpenFile('{{ $FileName }}')">
                <td>
                    <div class="fi fi-{{ $FileInfo['Extension'] }} fi-size-xs" style="float: left;">
                        <div class="fi-content">{{ $FileInfo['ExtShort'] }}</div>
                    </div>
                </td>
                <td>
                    {{ $FileName }}
                </td>
                <td>
                    {{ $FileInfo['ModifyDate'] }}
                </td>
                <td>
                    {{ $FileInfo['CreateDate'] }}
                </td>
                <td class="text-right">
                    {{ $FileInfo['Size'] }}
                </td>
                <td>

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm float-right" type="button"
                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            ...
                        </button>
                        <div class="dropdown-menu dropdown-file-menu bg-dark" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item text-light border-bottom-dark" onclick="DownloadFile('{{ $FileName }}')" href="#"><i class="fas fa-download"></i> Download</a>
                            <a class="dropdown-item text-light border-bottom-dark" onclick="OpenFile('{{ $FileName }}')" href="#"><i class="fas fa-pencil"></i> Edit</a>
                            <a class="dropdown-item text-light border-bottom-dark" onclick="DuplicateFile('{{ $FileName }}')" href="#"><i class="fas fa-copy"></i> Duplicate</a>
                            <a class="dropdown-item text-light border-bottom-dark" onclick="RenameFile('{{ $FileName }}')" href="#"><i class="fas fa-edit"></i> Rename</a>
                            <a class="dropdown-item text-danger" onclick="DeleteFile('{{ $FileName }}')" href="#"><i class="fas fa-trash"></i> Delete File</a>
                        </div>
                    </div>
                </td>

            </tr>
        @endforeach
    @endforeach



</table>
