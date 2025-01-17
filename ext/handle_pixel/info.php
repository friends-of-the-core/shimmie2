<?php

declare(strict_types=1);

class PixelFileHandlerInfo extends ExtensionInfo
{
    public const KEY = "handle_pixel";

    public string $key = self::KEY;
    public string $name = "Handle Pixel";
    public string $url = self::SHIMMIE_URL;
    public array $authors = self::SHISH_AUTHOR;
    public string $description = "Handle JPEG, PNG, GIF, WEBP, etc files";
    public bool $core = true;
}
