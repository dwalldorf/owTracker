class php::config inherits php {
    file { 'php5-fpm-www-conf':
        path    => '/etc/php/5.6/fpm/pool.d/www.conf',
        source  => 'puppet:///modules/php/php5-fpm-www-pool',
        ensure  => file,
        owner   => 'root',
        group   => 'root',
        mode    => 0644,
        require => Package['php5.6-fpm'],
        notify  => Service['php5.6-fpm'],
    }

    file { 'php5-fpm_ini':
        path    => '/etc/php/5.6/fpm/php.ini',
        source  => 'puppet:///modules/php/php.ini',
        ensure  => file,
        owner   => 'root',
        group   => 'root',
        mode    => 0644,
        require => Package['php5.6-fpm'],
        notify  => Service['php5.6-fpm'],
    }
    file { 'php5-cgi_ini':
        path    => '/etc/php/5.6/cgi/php.ini',
        source  => 'puppet:///modules/php/php.ini',
        ensure  => file,
        owner   => 'root',
        group   => 'root',
        mode    => 0644,
        require => Package['php5.6-cgi'],
        notify  => Service['php5.6-fpm'],
    }
    file { 'php5-cli_ini':
        path    => '/etc/php/5.6/cli/php.ini',
        source  => 'puppet:///modules/php/php-cli.ini',
        ensure  => file,
        owner   => 'root',
        group   => 'root',
        mode    => 0644,
        require => Package['php5.6-common'],
    }
}