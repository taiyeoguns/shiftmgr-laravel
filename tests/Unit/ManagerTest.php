<?php

namespace Tests\Unit;

use App\Manager;

use App\Shift;
use Tests\TestCase;

class ManagerTest extends TestCase
{
    /**
     * @test
     */
    public function manager_can_have_shifts()
    {
        $manager = factory(Manager::class)->create();
        $shifts = factory(Shift::class, 3)
            ->create()
            ->each(function ($s) use ($manager) {
                $s->manager()->associate($manager);
                $s->save();
            });

        $this->assertDatabaseHas('managers', ['id' => $manager->id]);
        $this->assertEquals(count($manager->shifts), 3);
    }
}
