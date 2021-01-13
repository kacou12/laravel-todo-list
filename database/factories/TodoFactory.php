<?php

namespace Database\Factories;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Todo::class;
    public $auteur;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titre' => $this->faker->name,
            'description' => $this->faker->sentence(10),
            //'auteur_membre_id' => $this->ct(),
            //'cible_membre_id' => $this->getRandomNumber($this->auteur),
            "done" => rand(0,1)
        ];
    }

    public function getRandomNumber($randit) {
        do {
            $n = rand(1,5);
        } while($randit == $n);
        return $n;
    }

    public function ct(){
        $this->auteur = rand(1,5);
        return $this->auteur;
    }
}
