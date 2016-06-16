class php::start inherits php {
    service { 'php5.6-fpm':
        ensure  => running,
        require => Package['php5.6-fpm']
    }
    service { 'memcached':
        ensure  => running,
        require => Package['memcached'],
    }
}