<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(50)->create();
        Book::factory(50)->create();
        $user1 = User::first();
        $book1 = Book::first();
        $user1->intervals()->attach($book1->id, ['start_page' => 10, 'end_page' => 30]);
        $book2 = Book::find(2);
        $user1->intervals()->attach(2, ['start_page' => 40, 'end_page' => 50]);
        $book2->uniqueReads()->create(['start_page' => 40, 'end_page' => 50]);
        $user2 = User::find(2);
        $user2->intervals()->attach(1, ['start_page' => 2, 'end_page' => 25]);
        $book1->uniqueReads()->create(['start_page' => 2, 'end_page' => 30]);
        $user3 = User::find(3);
        $user3->intervals()->attach(2, ['start_page' => 1, 'end_page' => 10]);
        $book2->uniqueReads()->create(['start_page' => 1, 'end_page' => 10]);
    }
}
