<?php

$email = $_POST['email'];

if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    
    exit("invalid format");
    
}

$api_key = "392371738142432e8ea0e71fa24095b5";

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => "https://emailvalidation.abstractapi.com/v1?api_key=$api_key&email=$email",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true
]);

$response = curl_exec($ch);

curl_close($ch);

$data = json_decode($response, true);
//var_dump($data);
//exit;

if ($data['deliverability'] === "UNDELIVERABLE") {
    
    exit("Undeliverable. This email id does not exist.");
    
}

if ($data["is_disposable_email"]["value"] === true) {
    
    exit("Disposable. Meaning the email's domain is found among Abstract's list of disposable email providers (e.g., Mailinator, Yopmail, etc)");
    
}

echo "This email address is valid.";
