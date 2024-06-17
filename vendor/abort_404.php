<?php
function abort_404()
{
    http_response_code(404);
    die();
}