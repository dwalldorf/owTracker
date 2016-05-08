class owt::start inherits owt {

    service { 'memcached':
        ensure  => running,
        require => Package['memcached'],
    }

}