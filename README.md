# Basic PHP and Symfony 2.8 interview

Dear candidate, please follow this readme and solve all questions.

> Before you can start, you should prepare your development environment.

**Using Symfony with Homestead/Vagrant**

In order to develop a Symfony application, you might want to use a virtual development environment instead of the built-in server or WAMP/LAMP. Homestead is an easy-to-use Vagrant box to get a virtual environment up and running quickly.

Before you can use Homestead, you need to install and configure Vagrant and Homestead as explained in the Homestead documentation.

Resources:
- [Using Symfony with Homestead/Vagrant](http://symfony.com/doc/current/cookbook/workflow/homestead.html)
- [Homestead documentation](http://laravel.com/docs/homestead#installation-and-setup)


**This test requires:**
- access to the internet
- an php capable IDE (we suggest PhpStorm with symfony, yaml, twig and php annotations plugin)
- working setup of PHP 5.6 *(http://symfony.com/doc/current/reference/requirements.html)*
- composer *(https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)*
- mongoDB *(https://docs.mongodb.com/manual/installation/)*
- nginx or alternative simple web server

*Tip: Install Robomongo on your OS*

*Tip: Clone the test repository and make sure its working.*
Access the project with your favourite browser. You should see similar welcome screen. **Dont forget to run composer install.**
![Symfony welcome screen](https://raw.githubusercontent.com/OskHa/php_interview_test/master/symfony_screenshot.png)

*Help: PHP 5.6+ (debian/ubuntu)*
> sudo apt-get install -qq php5-cli php5-fpm php5-mysqlnd php5-curl php5-gd php5-json php5-redis php5-imap php5-intl php5-imagick php5-mcrypt php5-xdebug php5-xmlrpc php5-xsl php5-twig php5-mongo php5-dev

*Help: (optional) PECL MongoDB library (debian/ubuntu)*
> sudo apt-get install pkg-config libssl-dev && sudo pecl update-channels && sudo pecl install mongodb

**Good luck!**


--------


## Test tasks:
/!\ Précision: je suis sous Windows ("/" "\")

1. Change the text on symfony homepage from "Welcome to Symfony 2.8.8" to "This is a test"
OK

1. Run the PhpUnit test. Check if there are any errors, if so fix them.
OK (en mettant en commentaires "swiftmailer" dans config_test.yml et modifier le test)
(commande à la racine : "phpunit -c app/ src/AppBundle/Tests/Controller/DefaultControllerTest.php")

1. Create a new Bundle "InterviewBundle" within the namespace "Test"
OK (changement de l'index de l'appli avec la commande generate:bundle)
(commande à la racine: "php app/console generate:bundle --namespace=Test/InterviewBundle --bundle-name=TestInterviewBundle")

1. Create a method helloAction under AppBundle\Controller\DefaultController
  * for route `/hello`
  * with a proper json return `{"hello":"world!"}`
Ok (return JsonResponse)

1. Create a "Bios" collection and load the example data into your MongoDB server
  * copy the json string from mongodb website ([link](https://docs.mongodb.com/manual/reference/bios-example-collection/))
  * or download and load the archive dump ([link](https://raw.githubusercontent.com/OskHa/php_interview_test/master/symfony_mongodb_example.archive))
OK mais il faut que vous fassiez la manip:
* mettre la collection en copier/coller dans une database "test" ou changer dans app/config/parameters.yml
* utiliser le dump symfony_mongodb_example.archive à la racine

1. Define ODM "Bios" document under namespace Test/InterviewBundle/Documents
Ok sauf qu'on ne doit pas utiliser "Documents" mais "Document" pour que le mapping fonctionne (pas trouvé d'autres solutions)
(commande à la racine pour les setters/getters: "php app/console doctrine:mongodb:generate:documents TestInterviewBundle")

1. Define ODM "Bios" repository under namespace Test/InterviewBundle/Repositories
Ok sauf qu'on doit utiliser "Repository" et non "Repositories"
(commande à la racine; "php app/console doctrine:mongodb:generate:repositories TestInterviewBundle")

/!\A partir de ce point, j'ai créé une methode (avec la route \testdb) pour tester les methodes demandées
De plus, les nouvelles routes sont définies dans le routing du Bundle pour la portabilité
1. Implement following repository methods
  * findByFirstName($firstName)
  * findByContribution($contributionName)
  * findByDeadBefore($year)
OK (on peut voir les résultats sur /testdb, on peut changer les paramètres des recherches dans le controller
src/Test/InterviewBundle/Controller/DefaultController.php)
/!\ les ids de la db sont parfois 'bizarre' (expl: 51df07b094c6acd67e492f41 (oui oui c'est bien un id))

1. Define and create a service "BiosService" under namespace Test/InterviewBundle/Services and implement following methods
  * getAllAwards()
  * Use the logger to log operations (error, warning, debug)
Ok, inscrit dans les services du Bundle (pour la portabilité)
Cependant, j'ai utilisé ma classe test pour tester le service, mais je ne me suis pas servi du logger

1. Create ContributionsController under namespace Test/InterviewBundle/Controller
OK

1. Add a contributionsAction method to your ContributionsController
  * for route `/contributions`
  * make a use of your BiosService
  * avoid logic under controller
  * method should list all contributions
  * with a proper json return `["contrib", ...]`
OK

1. Add a biosByContributionAction method to your ContributionsController
  * for route `/contributions/{contributionName}`
  * make a use of your BiosService
  * avoid logic under controller
  * method should list all bios documents with provided contribution
  * with a proper json return `[{...}]`
Ok

1. make a unit test for the controller
  * check if route `/hello` has response code 200
  * check if route `/hello` response is a json
  * check if route `/contributions` has response code 200
  * check if route `/contributions/fake` has response code 404
  * check if route `/contributions/OOP` has response code 200
Ok j'ai mis les tests dans Test/InterviewBundle/Tests/Controller/DefaultControllerTest.php
(commande à la racine: "phpunit -c app/ src/Test/InterviewBundle//Tests/Controller/DefaultControllerTest.php") 
 
1. make a unit test for the BiosService
  * at least 1 method of your choice
Ok j'ai mis un test de 'getAllContributions' avec retour Json à la suite des tests précédents

1. write a command called `test:command` that should accept 1 argument called id under namespace Test/InterviewBundle/Command
  * The command should check if a Bios document with an id of the argument exists
  * if document exists, return info "document exists"
  * if document doesnt exist, return error "document doesnt exist"
Ok (par contre Mongo a un petit soucis pour find un objet avec un id, pas moyen de le faire proprement en 'requête' alors j'ai du le faire en php)

## Bonus tasks

1. Go to app/config/config.yml and add the following yaml structure. **(NOTICE: ping is as child-key of test)**
```
test:
  ping: pong
```
Ok

1. Check the symfony application for errors and fix them if any.
Ok, j'ai du modifier "test:" en "test_interview:" qui est le namespace du bundle
et ajouter du code dans le DependencyInjection/Configuration pour ajouter le paramètre ping de valeur pong (valeur par défaut obligatoire)

1. write a prompt for the command `test:command`
  * Prompt text is "This is a test. Do you want to continue (y/N) ?"
  * If you decline, return error "Nothing done. Exiting..."
  * If you accept, run the command
OK, j'ai du modifier le code demandé en 15 forcément

# That's it!
## Thank you for your participation! Good luck submitting your results!
