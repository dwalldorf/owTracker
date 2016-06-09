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
}