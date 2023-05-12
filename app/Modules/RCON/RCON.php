<?php

namespace App\Modules\RCON;

use Exception;

class RCON
{

    // Setting variables
    private $Host;
    private $Port;
    private $Pass;
    private $Time = 60;
    private $Sock;
    private $Auth = false;
    private $Resp = "";

    // Setting Constants
    private const PACKAUTH = 5;
    private const PACKCMD = 6;
    private const SERVERAUTH = 3;
    private const SERVERAUTHRESP = 2;
    private const SERVERCMD = 2;
    private const SERVERRESP = 0;

    public function __construct($Pass = "", $Host = "127.0.0.1", $Port = 25575)
    {
        $this->Host = $Host;
        $this->Port = $Port;
        $this->Pass = $Pass;
    }

    public function Connect(): self
    {
        $this->Sock = fsockopen(
            $this->Host,
            $this->Port,
            $E_No,
            $E_Msg,
            $this->Time
        );
        if (!$this->Sock) {
            throw new Exception($E_Msg, $E_No);
        }
        return $this;
    }

    private function Login(): bool
    {
        $this->SendPacket(self::PACKAUTH, self::SERVERAUTH, $this->Pass);
        $RecievedPacket = $this->RecievePacket();
        if ($RecievedPacket['type'] == self::SERVERAUTHRESP) {
            if ($RecievedPacket['id'] == self::PACKAUTH) {
                $this->Auth = true;
                return $this->Auth;
            }
        }
        return false;
    }

    // Building packet to send to host
    private function SendPacket($PID, $PType, $PBody): void
    {
        $Packet = pack('VV', $PID, $PType);
        $Packet = $Packet . $PBody . "\x00"; //Terminating string
        $Packet = $Packet . "\x00"; //Terminating string
        $Packet = pack('V', strlen($Packet)) . $Packet;
        fwrite($this->Sock, $Packet, strlen($Packet));
    }

    // Unpacking Packet recieved from host
    private function RecievePacket(): array
    {
        return unpack(
            'V1id/V1type/a*body',
            fread(
                $this->Sock,
                unpack(
                    'V1size',
                    fread(
                        $this->Sock,
                        4
                    )
                )['size']
            )
        );
    }

    public function SendCommand(string $Command): string|bool
    {
        if (!$this->Login()) {
            throw new \Exception("Couldn't login to the RCON server. Please check your settings!");
        }
        $this->SendPacket(self::PACKCMD, self::SERVERCMD, $Command);
        $Response = $this->RecievePacket();
        if ($Response['id'] == self::PACKCMD) {
            if ($Response['type'] == self::SERVERRESP) {
                $this->Resp = $Response['body'];
               // socket_close($this->Sock);
                return $this->Resp;
            }
        }
        return false;
    }
    /********************** */
    // Getters and Setters
    /********************** */
    public function SetHost($Host): self
    {
        $this->Host = $Host;
        return $this;
    }

    public function GetHost(): string
    {
        return $this->Host;
    }

    public function SetPort($Port): self
    {
        $this->Port = $Port;
        return $this;
    }

    public function GetPort(): int
    {
        return $this->Port;
    }

    public function SetPass($Pass): self
    {
        $this->Pass = $Pass;
        return $this;
    }

    public function GetPass(): string
    {
        return $this->Pass;
    }

    public function SetTime($Time): self
    {
        $this->Time = $Time;
        return $this;
    }

    public function GetTime(): int
    {
        return $this->Time;
    }

    public function GetResponse(): string
    {
        return $this->Resp;
    }
}
