<?php
function HTMLRaw($output) {
    if($output) {
        echo $output;
    }
}

function HTMLEscaped($output) {
    if(isset($output)) {
        echo htmlspecialchars($output);
    }
}

function getRootPath() {
    return '/swd501/website';
}

function clearResponseSession() {
    unset($_SESSION['response']);
}

function handleResponse($inputs = null) {
    $response = ['output' => "", 'previous_data' => $inputs];

    if(isset($_SESSION['response'])) {
        if(isset($_SESSION['response']['message'])) {
            $response['output'] = '<div class="response_output">' . $_SESSION['response']['message'] . '</div>';
        }

        if(isset($_SESSION['response']['previous_data'])) {
            $response['previous_data'] = $_SESSION['response']['previous_data'];
        }

        clearResponseSession();
    }

    return $response;
}