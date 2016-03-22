class base::config inherits base {

    file { 'bash_profile':
        path    => '/home/vagrant/.profile',
        source  => 'puppet:///modules/base/.profile',
        ensure  => file,
        owner   => vagrant,
        group   => vagrant,
        mode    => 0644,
    }
    file { 'zprofile':
        path    => '/home/vagrant/.zprofile',
        source  => 'puppet:///modules/base/.zprofile',
        ensure  => file,
        owner   => vagrant,
        group   => vagrant,
        mode    => 0644,
    }
    file { 'my-zsh_custom_vagrant':
        path    => '/home/vagrant/.my-zsh/custom',
        source  => 'puppet:///modules/base/my-zsh/custom',
        ensure  => file,
        owner   => vagrant,
        group   => vagrant,
        mode    => 0644,
        require => Exec['install_my-zsh_vagrant'],
    }
    file { 'my-zsh_custom_root':
        path    => '/root/.my-zsh/custom',
        source  => 'puppet:///modules/base/my-zsh/custom',
        ensure  => file,
        owner   => root,
        group   => root,
        mode    => 0644,
        require => Exec['install_my-zsh_root'],
    }

}