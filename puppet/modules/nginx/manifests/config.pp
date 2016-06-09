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
        content  => template('nginx/owt.localhost.erb'),
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
}