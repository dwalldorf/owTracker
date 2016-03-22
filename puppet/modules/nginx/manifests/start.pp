class nginx::start inherits nginx {

    service { 'nginx':
        ensure  => running,
        require => Package['nginx']
    }

    service { 'php5-fpm':
        ensure  => running,
        require => Package['php5-fpm']
    }

}