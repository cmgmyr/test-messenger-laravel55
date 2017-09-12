<?php

use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class MessengerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        Message::unguard();
        Message::truncate();
        Participant::unguard();
        Participant::truncate();
        Thread::unguard();
        Thread::truncate();

        foreach(range(1, 10) as $index) {
            $users = collect([1, 2, 3]);
            $creator = $users->pull(rand(0, 2));

            $thread = Thread::create([
                'subject' => $faker->words(rand(4, 8), true),
            ]);

            // Message
            Message::create([
                'thread_id' => $thread->id,
                'user_id'   => $creator,
                'body'      => $faker->paragraph(),
            ]);

            // Sender
            Participant::create([
                'thread_id' => $thread->id,
                'user_id'   => $creator,
                'last_read' => new Carbon,
            ]);

            // Recipients
            $thread->addParticipant($users->take(rand(1, 2))->toArray());

            $participants = $thread->participants()->pluck('user_id');

            // Participant messages
            foreach(range(1, 10) as $index) {
                Message::create([
                    'thread_id' => $thread->id,
                    'user_id'   => $participants->random(),
                    'body'      => $faker->paragraph(),
                ]);
            }
        }
    }
}
