class php::install inherits php {
    apt::ppa{ 'ppa:ondrej/php': }
    apt::key{ 'ppa:ondrej/php':
        id  => '14AA40EC0831756756D7F66C4F4EA0AAE5267A6C',
    }

    package { 'php5.6-common':
        ensure  => latest,
        require => [
            Apt::Ppa['ppa:ondrej/php'],
            Apt::Key['ppa:ondrej/php'],
        ],
    }
    package{ 'php5.6-xml':
        ensure  => latest,
        require => Package['php5.6-common'],
    }
    package{ 'php-stomp':
        ensure  => latest,
        require => Package['php5.6-common'],
    }
    package { 'php5.6-cgi':
        ensure  => latest,
        require => Package['php5.6-common'],
        notify  => Service['php5.6-fpm'],
    }
    package { 'php5.6-fpm':
        ensure  => latest,
        require => Package['php5.6-common'],
    }
    package { 'php5.6-intl':
        ensure  => latest,
        require => Package['php5.6-common'],
        notify  => Service['php5.6-fpm'],
    }
    package{ 'php5.6-zip':
        ensure  => latest,
        require => Package['php5.6-common'],
    }
    package{ 'php5.6-bcmath':
        ensure  => latest,
        require => Package['php5.6-common'],
    }
    package{ 'php5.6-mbstring':
        ensure  => latest,
        require => Package['php5.6-common'],
    }
    package{ 'php5.6-curl':
        ensure  => latest,
        require => Package['php5.6-common'],
    }
    package { 'memcached':
        ensure => latest,
    }
    package { 'php-memcache':
        ensure  => latest,
        require => Package['php5.6-common'],
        notify  => Service['php5.6-fpm'],
    }
    package{ 'php-xcache':
        ensure  => latest,
        require => Package['php5.6-common'],
        notify  => Service['php5.6-fpm'],
    }

    exec { 'install_phpunit':
        command => 'wget -q https://phar.phpunit.de/phpunit.phar && chmod +x phpunit.phar && mv phpunit.phar /usr/local/bin/phpunit',
        require => Package['curl'],
        user    => root,
        creates => '/usr/local/bin/phpunit',
        path    => ['/bin', '/usr/bin'],
        cwd     => '/tmp',
    }
}