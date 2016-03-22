# owTracker - The CS:GO Overwatch tracker

# dev setup

## Requirements
You need to have vagrant installed. If you haven't, get it: [vagrantup.com](https://www.vagrantup.com/)

## Get it running
Check out the code base: `git checkout https://github.com/dwalldorf/owTracker.git`

Get vagrant running: (from inside the project directory)`vagrant up` and get a coffee.

Once vagrant has finished it's setup, connect to the vm and set up the project:

    vagrant ssh
    cd /vagrant
    composer install
    npm install

That should be it. Now you can point your browser to [localhost:8080/app.php](http://localhost:8080/app.php) or [localhost:8080/app_dev.php](http://localhost:8080/app_dev.php).
