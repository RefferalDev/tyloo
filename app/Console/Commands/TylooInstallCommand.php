<?php

namespace App\Console\Commands;

use App\Customer;
use App\Post;
use App\Tag;
use App\User;
use App\Work;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TylooInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tyloo:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and Setup the application with dummy data.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // We migrate the database
        $this->info('Migrating the database tables...');
        Artisan::call('migrate:fresh');

        // We create the default user
        $this->info('Creating the default user...');
        list($name, $email, $password) = $this->askForInitialUserCredentials();
        $user = $this->createInitialUser($name, $email, $password);
        $this->info($name.' ('.$email.') created successfully!');

        // We ask the user to add dummy data
        if ($this->confirm('Do you want to insert some dummy data (tags, posts, works, customers)?')) {
            $this->createDummyData($user);

            $this->info('Dummy data inserted successfully!');
        }

        $this->info("\nInitial installation done with success! Enjoy using Tyloo and don't hesitate to post feedbacks ;)");
    }

    /**
     * Ask for initial user's name, email and password.
     *
     * @return array
     */
    protected function askForInitialUserCredentials()
    {
        $name = $this->ask('Your name');
        $email = null;
        while (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = $this->ask('Your email');
        }
        $password = $this->secret('Your password');
        $password_confirmation = null;
        while ($password != $password_confirmation) {
            $password_confirmation = $this->secret('Confirm');
        }

        return [$name, $email, $password];
    }

    /**
     * Create the initial user via factory.
     *
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return User
     */
    private function createInitialUser($name, $email, $password)
    {
        return factory(User::class)
            ->create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
            ]);
    }

    /**
     * Create dummy data for the initial user (tags, posts, works, customers).
     *
     * @param User $user
     */
    private function createDummyData(User $user)
    {
        // We create 3 customers
        factory(Customer::class, 3)->create();

        // We create 5 published posts
        factory(Post::class, 5)->states('published')->create([
            'user_id' => $user->id,
        ])->each(function ($post) {
            $post->tags()->save(factory(Tag::class)->create());
        });

        // We create 5 unpublished posts
        factory(Post::class, 5)->create([
            'user_id' => $user->id,
        ])->each(function ($post) {
            $post->tags()->save(factory(Tag::class)->create());
        });

        // We create 5 published works
        factory(Work::class, 3)->states('published')->create([
            'user_id' => $user->id,
        ])->each(function ($work) {
            $work->tags()->save(factory(Tag::class)->create());
        });

        // We create 5 unpublished works
        factory(Work::class, 3)->create([
            'user_id' => $user->id,
        ])->each(function ($work) {
            $work->tags()->save(factory(Tag::class)->create());
        });
    }
}
