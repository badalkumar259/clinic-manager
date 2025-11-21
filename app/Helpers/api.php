<?php

function api_success($data = null, $message = 'OK', $status = 200)
{
    return response()->json(['success' => true,'message' => $message,'data' => $data], $status);
}

function api_error($message = 'Error', $errors = null, $status = 422)
{
    return response()->json(['success' => false,'message' => $message,'errors' => $errors], $status);
}
