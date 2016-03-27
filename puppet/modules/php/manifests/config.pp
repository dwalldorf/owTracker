class php::config inherits php {
    file { 'php5-fpm-www-conf':
        path    => '/etc/php5/fpm/pool.d/www.conf',
        source  => 'puppet:///modules/php/php5-fpm-www-pool',
        ensure  => file,
        owner   => 'root',
        group   => 'root',
        mode    => 0644,
        require => Package['php5-fpm'],
        notify  => Service['php5-fpm'],
    }

    file { 'php5-fpm_ini':
        path    => '/etc/php5/fpm/php.ini',
        source  => 'puppet:///modules/php/php.ini',
        ensure  => file,
        owner   => 'root',
        group   => 'root',
        mode    => 0644,
        require => Package['php5-fpm'],
        notify  => Service['php5-fpm'],
    }
}