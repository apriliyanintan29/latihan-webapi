<?php

use Illuminate\Database\Seeder;
use App\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Student::create(
        	[
    			'nama'  => 'Akmal',
    			'jk'	=> 'L'
    		]
        );

        Student::create(
        	[
    			'nama'  => 'Intan',
    			'jk'	=> 'P'
    		]
        );

        for ($i=0; $i < 20; $i++) { 
            $jk = 'P';
            if ($i > 10) {
                $jk = 'L';
            }
            Student::create([
                'nama'  => 'kamal-' . $i,
                'jk'    => $jk
            ]);
        }
    }
}
