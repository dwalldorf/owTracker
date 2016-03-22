Vagrant.configure(2) do |config|
    config.vm.box = "ubuntu/trusty64"
    config.vm.hostname = "localhost"
    config.vm.box_check_update = true
    config.vm.network "forwarded_port", guest: 80, host: 8080

    config.vm.provider "virtualbox" do |v|
        v.memory = 2048
        v.cpus = 2
    end

    config.vm.provision "puppet" do |puppet|
        puppet.manifests_path = "puppet/manifests"
        puppet.manifest_file = "default.pp"
        puppet.module_path = "puppet/modules"
    end
end