<?php

declare(strict_types=1);

class MediamtxAuth extends Extension
{
    public function onPageRequest(PageRequestEvent $event)
    {
        global $config, $page, $user;

        if ($_SERVER['REQUEST_METHOD'] == "POST" && $event->page_matches("api/mediamtx")) {
            $page->set_mode(PageMode::DATA);
            $page->set_mime(MimeType::TEXT);

            $json_string = file_get_contents("php://input");

            if (is_null($json_string)) {
                $page->set_code(401);
                $page->set_data(json_encode("Unauthorized (No Input)"));
                return;
            }

            $json_data = json_decode($json_string, true);

            if (is_null($json_data)) {
                $page->set_code(401);
                $page->set_data(json_encode("Unauthorized (No Data)"));
                return;
            }

            $duser = User::by_name_and_pass($json_data['user'], $json_data['password']);
            if (!is_null($duser)) {
                $user = $duser;
            } else {
                $user = User::by_id($config->get_int("anon_id", 0));
            }
            send_event(new UserLoginEvent($user));

            if ($user->is_anonymous()) {
                if ($json_data['action'] == 'read') {
                    $page->set_code(200);
                    $page->set_data(json_encode("Authorized"));
                    return;
                }

                $page->set_code(401);
                $page->set_data(json_encode("Unauthorized (Invalid Credentials)"));
                return;
            }

            $page->set_code(200);
            $page->set_data(json_encode("Authorized"));
        }
    }
}
