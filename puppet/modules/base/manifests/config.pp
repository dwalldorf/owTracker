class base::config inherits base {
    file { 'bash_profile_vagrant':
        path    => '/home/vagrant/.profile',
        content  => template('base/profile.erb'),
        ensure  => file,
        owner   => vagrant,
        group   => vagrant,
        mode    => 0644,
    }
    file { 'zprofile_vagrant':
        path    => '/home/vagrant/.zshrc',
        source  => 'puppet:///modules/base/.zshrc',
        ensure  => file,
        owner   => vagrant,
        group   => vagrant,
        mode    => 0644,
    }
    file { 'my-zsh_custom_vagrant':
        path    => '/home/vagrant/.my-zsh/custom',
        content  => template('base/zsh-custom.erb'),
        ensure  => file,
        owner   => vagrant,
        group   => vagrant,
        mode    => 0644,
        require => Exec['install_my-zsh_vagrant'],
    }

    exec { 'chsh_vagrant':
        command => 'chsh -s /bin/zsh vagrant',
        path    => '/usr/bin',
        user    => root,
        require => Package['zsh'],
    }

    file { 'bash_profile_root':
        path    => '/root/.profile',
        content  => template('base/profile.erb'),
        ensure  => file,
        owner   => root,
        group   => root,
        mode    => 0644,
    }
    file { 'zprofile_root':
        path    => '/root/.zshrc',
        source  => 'puppet:///modules/base/.zshrc',
        ensure  => file,
        owner   => root,
        group   => root,
        mode    => 0644,
    }
    file { 'my-zsh_custom_root':
        path    => '/root/.my-zsh/custom',
        content  => template('base/zsh-custom.erb'),
        ensure  => file,
        owner   => root,
        group   => root,
        mode    => 0644,
        require => Exec['install_my-zsh_root'],
    }

    exec { 'chsh_root':
        command => 'chsh -s /bin/zsh',
        path    => '/usr/bin',
        user    => root,
        require => Package['zsh'],
    }
}