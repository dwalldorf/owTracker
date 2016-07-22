class php::config inherits php {
    file { 'php5-fpm-www-conf':
        path    => '/etc/php/7.0/fpm/pool.d/www.conf',
        source  => 'puppet:///modules/php/php5-fpm-www-pool',
        ensure  => file,
        owner   => 'root',
        group   => 'root',
        mode    => 0644,
        require => Package['php7.0-fpm'],
        notify  => Service['php7.0-fpm'],
    }

    file { 'php7.0-fpm_ini':
        path    => '/etc/php/7.0/fpm/php.ini',
        source  => 'puppet:///modules/php/php.ini',
        ensure  => file,
        owner   => 'root',
        group   => 'root',
        mode    => 0644,
        require => Package['php7.0-fpm'],
        notify  => Service['php7.0-fpm'],
    }
    file { 'php7.0-cgi_ini':
        path    => '/etc/php/7.0/cgi/php.ini',
        source  => 'puppet:///modules/php/php.ini',
        ensure  => file,
        owner   => 'root',
        group   => 'root',
        mode    => 0644,
        require => Package['php7.0-cgi'],
        notify  => Service['php7.0-fpm'],
    }
    file { 'php7.0-cli_ini':
        path    => '/etc/php/7.0/cli/php.ini',
        source  => 'puppet:///modules/php/php-cli.ini',
        ensure  => file,
        owner   => 'root',
        group   => 'root',
        mode    => 0644,
        require => Package['php7.0-common'],
    }
}