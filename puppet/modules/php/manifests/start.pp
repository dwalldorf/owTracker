class php::start inherits php {
    service { 'php7.0-fpm':
        ensure  => running,
        require => Package['php7.0-fpm']
    }
    service { 'memcached':
        ensure  => running,
        require => Package['memcached'],
    }
}