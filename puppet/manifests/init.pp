$owtDir = "/usr/share/nginx/owt"
$parserDir = "/opt/demo-parser"

exec { 'apt-update':
    command => '/usr/bin/apt-get update'
}
Exec['apt-update'] -> Package <| |>

include apt
include base
include nginx
include mongo
include php
include owt
include demo-parser