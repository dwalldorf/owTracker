class nginx::install inherits nginx {

    package { 'nginx':
        ensure => latest,
    }
    package { 'default-jre':
        ensure => latest,
    }
    package{ 'apache2':
        ensure  => purged,
        require => Package['php5', 'php5-cgi', 'php5-fpm', 'php5-intl'],
    }

    package { 'memcached':
        ensure => latest,
    }

    package { 'ruby':
        ensure => latest,
    }
    exec { 'install_sass':
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
    exec { 'install_composer':
        command    => 'curl -sS https://getcomposer.org/installer | /usr/bin/php && sudo mv /tmp/composer.phar /usr/local/bin/composer',
        require    => Package['curl', 'php5', 'git'],
        environment=>'HOME=/home/vagrant',
        user       => vagrant,
        creates    =>'/usr/local/bin/composer',
        path       => '/usr/bin',
        cwd        => '/tmp'
    }
}