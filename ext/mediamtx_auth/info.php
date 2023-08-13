<?php

declare(strict_types=1);

class MediamtxAuthInfo extends ExtensionInfo
{
    public const KEY = "mediamtx_auth";

    public string $key = self::KEY;
    public string $name = "MediaMTX Authentication";
    public array $authors = ["Ticky"=>"ticky@drac.at"];
    public string $description = "Authenticate MediaMTX stream publishers with Shimmie user credentials";
}
