class php::install inherits php {
    package { 'php5':
        ensure => latest,
    }
    package { 'php5-cgi':
        ensure  => latest,
        notify  => Service['php5-fpm'],
    }
    package { 'php5-fpm':
        ensure => latest,
    }
    package { 'php5-memcached':
        ensure  => latest,
        require => Package['memcached'],
        notify  => Service['php5-fpm'],
    }
    package { 'php5-intl':
        ensure  => latest,
        notify  => Service['php5-fpm'],
    }
}