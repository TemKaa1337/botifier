<?php

declare(strict_types=1);

namespace Temkaa\Botifier\Service;

final readonly class RequestPreparator
{

}
// use GuzzleHttp\Psr7\Request;
// use Http\Factory\Guzzle\StreamFactory;
// use Http\Factory\Guzzle\RequestFactory;
//
// function createMultipartFormDataWithJsonAndFileRequest($url, $method, $jsonFields, $fileFields)
// {
//     $boundary = '----WebKitFormBoundary' . bin2hex(random_bytes(16));  // generate unique boundary
//
//     // Initialize body content
//     $bodyContent = '';
//
//     // Add JSON fields
//     foreach ($jsonFields as $name => $value) {
//         $bodyContent .= "--{$boundary}\r\n";
//         $bodyContent .= "Content-Disposition: form-data; name=\"{$name}\"\r\n\r\n";
//         $bodyContent .= "{$value}\r\n";
//     }
//
//     // Add file fields
//     foreach ($fileFields as $name => $filePath) {
//         $filename = basename($filePath);
//         $fileContent = file_get_contents($filePath);
//         $mimeType = mime_content_type($filePath);
//
//         $bodyContent .= "--{$boundary}\r\n";
//         $bodyContent .= "Content-Disposition: form-data; name=\"{$name}\"; filename=\"{$filename}\"\r\n";
//         $bodyContent .= "Content-Type: {$mimeType}\r\n\r\n";
//         $bodyContent .= $fileContent . "\r\n";
//     }
//
//     // Close the boundary
//     $bodyContent .= "--{$boundary}--\r\n";
//
//     // Create the stream for the body
//     $streamFactory = new StreamFactory();
//     $bodyStream = $streamFactory->createStream($bodyContent);
//
//     // Create the request with headers and body
//     $requestFactory = new RequestFactory();
//     $request = $requestFactory->createRequest($method, $url)
//         ->withHeader('Content-Type', "multipart/form-data; boundary={$boundary}")
//         ->withBody($bodyStream);
//
//     return $request;
// }
//
// // Usage
// $jsonFields = [
//     'field1' => 'value1',
//     'field2' => 'value2'
// ];
// $fileFields = [
//     'file1' => '/path/to/your/file1.jpg',
//     'file2' => '/path/to/your/file2.png'
// ];
// $request = createMultipartFormDataWithJsonAndFileRequest('https://example.com/api/upload', 'POST', $jsonFields, $fileFields);
//
// // Now you can send this request using any PSR-18 compatible HTTP client
