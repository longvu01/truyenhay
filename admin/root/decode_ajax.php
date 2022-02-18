<?php
  $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

  $content = trim(file_get_contents("php://input"));
  $content = trim(file_get_contents("php://input"));
  $decoded = json_decode($content, true);