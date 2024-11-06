<?php

require "../lib/vendor/autoload.php";

$service = new PHPSupabase\Service(
    "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InpheGRlaGt2c253YWJ2b3l5ZXN6Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzA0NjMyNjAsImV4cCI6MjA0NjAzOTI2MH0.RBCCjHhdeN9AboULGfFOTngF5nq_tbImynDnb7NnakI",
    "https://zaxdehkvsnwabvoyyesz.supabase.co"
);

$auth = $service->createAuth();