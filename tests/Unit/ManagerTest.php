<?php

namespace Tests\Unit;

use App\Models\Manager;
use App\Models\Shift;
use Tests\TestCase;

class ManagerTest extends TestCase
{
    /**
     * @test
     */
    public function manager_can_have_shifts()
    {
        $manager = factory(Manager::class)->create();
        factory(Shift::class, 3)
            ->create()
            ->each(function ($s) use ($manager) {
                $s->manager()->associate($manager);
                $s->save();
            });

        $this->assertDatabaseHas('managers', ['id' => $manager->id]);
        $this->assertEquals(count($manager->shifts), 3);
    }
}
