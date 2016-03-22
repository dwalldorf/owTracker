class nginx::config inherits nginx {

    file { 'nginx_conf':
        path    => '/etc/nginx/nginx.conf',
        source  => 'puppet:///modules/nginx/nginx.conf',
        ensure  => file,
        owner   => 'root',
        group   => 'root',
        mode    => 0644,
        notify  => Service['nginx'],
        require => Package['nginx'],
    }

    file { 'nginx_default':
        path    => '/etc/nginx/sites-available/default',
        ensure  => absent,
        require => File['nginx_default_enabled'],
    }
    file { 'nginx_default_enabled':
        path    => '/etc/nginx/sites-enabled/default',
        ensure  => absent,
        notify  => Service['nginx'],
        require => Package['nginx'],
    }

    file { 'nginx_owt':
        path    => '/etc/nginx/sites-available/owt.localhost',
        source  => 'puppet:///modules/nginx/owt.localhost',
        ensure  => file,
        owner   => 'root',
        group   => 'root',
        mode    => 0644,
        notify  => Service['nginx'],
        require => Package['nginx'],
    }
    file { 'nginx_owt_enabled':
        path    => '/etc/nginx/sites-enabled/owt.localhost',
        ensure  => link,
        target  => '/etc/nginx/sites-available/owt.localhost',
        notify  => Service['nginx'],
        require => File['nginx_owt'],
    }

    file { 'php5-fpm-www-conf':
        path    => '/etc/php5/fpm/pool.d/www.conf',
        source  => 'puppet:///modules/nginx/php5-fpm-www-pool',
        ensure  => file,
        owner   => 'root',
        group   => 'root',
        mode    => 0644,
        require => Package['php5-fpm'],
        notify  => Service['php5-fpm'],
    }

}