class nginx::install inherits nginx {

    package { 'nginx':
        ensure => latest,
    }
    package { 'default-jre':
        ensure => latest,
    }

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

    package { 'memcached':
        ensure => latest,
    }

    package { 'ruby':
        ensure => latest,
    }
    exec { 'sass':
        user    => root,
        command => '/usr/bin/gem install sass',
        require => Package['ruby'],
        creates => '/usr/local/bin/sass',
    }
    package { 'ruby-sass':
        ensure  => latest,
        require => Package['ruby'],
    }
    package { 'ruby-compass':
        ensure  => latest,
        require => Package['ruby-sass'],
    }

    package { 'curl':
        ensure => installed,
    }
    exec { 'install composer':
        command => 'curl -sS https://getcomposer.org/installer | /usr/bin/php && sudo mv /tmp/composer.phar /usr/local/bin/composer',
        require => Package['curl', 'php5', 'git'],
        creates =>'/usr/local/bin/composer',
        path    => '/usr/bin',
        cwd     => '/tmp'
    }
}