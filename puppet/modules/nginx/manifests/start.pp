class nginx::start inherits nginx {
    service { 'nginx':
        ensure  => running,
        require => Package['nginx']
    }
}