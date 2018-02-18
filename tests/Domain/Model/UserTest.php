<?php

namespace Realworld\Domain\Model;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testHasId()
    {
        $user = new User(1, "Name", "test@example.org", "", "", "");

        $this->assertSame(1, $user->id);
    }

    public function testHasName()
    {
        $user = new User(0, "Name", "test@example.org", "", "", "");

        $this->assertSame("Name", $user->name);
    }


    public function testHasEmail()
    {
        $user = new User(0, "Name", "test@example.org", "", "", "");

        $this->assertSame("test@example.org", $user->email);
    }

    public function testHasPasswordHash()
    {
        $user = new User(0, "Name", "test@example.org", "fhgnv93756smv45k", "", "");

        $this->assertSame("fhgnv93756smv45k", $user->passwordHash);
    }

    public function testHasBio()
    {
        $user = new User(0, "Name", "test@example.org", "", "Biography", "");

        $this->assertSame("Biography", $user->bio);
    }

    public function testHasImage()
    {
        $user = new User(0, "Name", "test@example.org", "", "", "http://example.org/images/user_0.jpeg");

        $this->assertSame("http://example.org/images/user_0.jpeg", $user->image);
    }

    public function testCanBeCreatedWithStaticConstructor()
    {
        $user = User::create("Name", "test@example.org", "0000", "", "");

        $this->assertInstanceOf(User::class, $user);
    }

    public function testCannotBeCreatedWithEmptyName()
    {
        $this->expectException(\Throwable::class);

        new User(0, "", "test@example.org", "", "", "");
    }

    public function testCannotBeCreatedWithInvalidEmail()
    {
        $this->expectException(\Throwable::class);

        new User(0, "Name", "not an email", "", "", "");
    }

    public function testCannotBeCreatedWithEmptyPassword()
    {
        $this->expectException(\Throwable::class);

        User::create("Name", "test@example.org", "", "", "");
    }
}