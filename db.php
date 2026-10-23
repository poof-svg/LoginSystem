<?php

$db = 'aws-0-ap-south-1.pooler.supabase.com';
$dbUser = 'postgres.eqakpovpzwdqvgxdvluu';
$dbPassword = 'Phloem12345*@';


$conn = pg_connect("host=$db port=5432 dbname=postgres user=$dbUser password=$dbPassword sslmode=require");

if (!$conn){
    exit('Database connection failed.');
}
