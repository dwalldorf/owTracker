class php::start inherits php {
    service { 'php5-fpm':
        ensure  => running,
        require => Package['php5-fpm']
    }
    service { 'memcached':
        ensure  => running,
        require => Package['memcached'],
    }
}