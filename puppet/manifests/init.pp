$owtDir = "/usr/share/nginx/owt"

exec { 'apt-update':
    command => '/usr/bin/apt-get update'
}

Apt::Ppa <| |> ->
Apt::Key <| |> ->
Exec['apt-update'] ->
Package <| |>

include apt
include base

include nginx
include mongo
include couchdb
include php
include owt
include demo-parser