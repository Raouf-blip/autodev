<?php

namespace App\Console;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Office;
use Faker\Factory;
use Slim\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateDatabaseCommand extends Command
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('db:populate');
        $this->setDescription('Populate database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Populate database...');

        /** @var \Illuminate\Database\Capsule\Manager $db */
        $db = $this->app->getContainer()->get('db');

        // Vider les tables
        $db->getConnection()->statement("SET FOREIGN_KEY_CHECKS=0");
        $db->getConnection()->statement("TRUNCATE `employees`");
        $db->getConnection()->statement("TRUNCATE `offices`");
        $db->getConnection()->statement("TRUNCATE `companies`");
        $db->getConnection()->statement("SET FOREIGN_KEY_CHECKS=1");

        // Initialiser Faker avec la locale française
        $faker = Factory::create('fr_FR');

        // Générer 2 à 4 sociétés
        $nbCompanies = rand(2, 4);
        $output->writeln("Génération de $nbCompanies sociétés...");

        for ($i = 0; $i < $nbCompanies; $i++) {
            // Créer une société
            $company = new Company();
            $company->name = $faker->company();
            $company->phone = $faker->phoneNumber();
            $company->email = $faker->companyEmail();
            $company->website = $faker->url();
            $company->image = $faker->imageUrl(800, 600, 'business', true);
            $company->save();

            $output->writeln("  - Société créée : {$company->name}");

            // Générer 2 à 3 bureaux pour cette société
            $nbOffices = rand(2, 3);
            $offices = [];

            for ($j = 0; $j < $nbOffices; $j++) {
                $office = new Office();
                $office->name = $faker->randomElement(['Siège social', 'Bureau', 'Agence']) . ' ' . $faker->city();
                $office->address = $faker->streetAddress();
                $office->city = $faker->city();
                $office->zip_code = $faker->postcode();
                $office->country = $faker->country();
                $office->email = $faker->email();
                $office->phone = $faker->phoneNumber();
                $office->company_id = $company->id;
                $office->save();

                $offices[] = $office;
                $output->writeln("    - Bureau créé : {$office->name}");

                // Générer 3 à 4 employés par bureau
                $nbEmployees = rand(3, 4);

                for ($k = 0; $k < $nbEmployees; $k++) {
                    $employee = new Employee();
                    $employee->first_name = $faker->firstName();
                    $employee->last_name = $faker->lastName();
                    $employee->email = $faker->email();
                    $employee->phone = $faker->phoneNumber();
                    $employee->job_title = $faker->jobTitle();
                    $employee->office_id = $office->id;
                    $employee->save();
                }
            }

            // Définir le premier bureau comme siège social
            if (!empty($offices)) {
                $company->head_office_id = $offices[0]->id;
                $company->save();
            }
        }

        $output->writeln('Base de données peuplée avec succès !');
        return 0;
    }
}
