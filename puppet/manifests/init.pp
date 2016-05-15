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