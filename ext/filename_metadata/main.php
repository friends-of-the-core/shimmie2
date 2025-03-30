<?php

declare(strict_types=1);

class FilenameMetadata extends Extension
{
    public function get_priority(): int
    {
        return 40;
    }

    // > [Discord usernames are now] limited to lowercase characters (a-z),
    // > numbers (0-9) and two special characters (period and underscore)
    // Source: https://discord.com/blog/usernames
    public const FILENAME_REGEX = '/\[(?<username>[a-zA-Z0-9\._]+)-(?<date>[\w:\.\+-]+)\]-(?<discord_id>\w+)-(?<filename>.+)/';

    public function onImageAddition(ImageAdditionEvent $event)
    {
        if (preg_match(self::FILENAME_REGEX, $event->image->filename, $matches)) {
            if (!is_array($event->image->tag_array)) {
                $event->image->tag_array = [];
            }
            $event->image->tag_array[] = "photographer:".$matches["username"];

            $event->image->posted = $matches["date"];
            $event->image->filename = $matches["filename"];
        }
    }
}
