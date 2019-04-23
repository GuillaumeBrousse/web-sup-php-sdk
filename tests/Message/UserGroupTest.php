<?php
declare(strict_types=1);

namespace Serato\UserProfileSdk\Test\Message;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Serato\UserProfileSdk\Message\UserGroup;

class UserGroupTest extends PHPUnitTestCase
{
    public function testSettersWithCorrectValues()
    {
        $userId = 123;
        $groups = [
            [
                UserGroup::ID => 5,
                UserGroup::NAME => "Group Five"
            ],
            [
                UserGroup::ID => 40,
                UserGroup::NAME => "Group Forty"
            ]
        ];

        $userGroup = UserGroup::create($userId)->setGroups($groups);

        $this->assertEquals('UserGroup', $userGroup->getType());
        $this->assertEquals($groups, $userGroup->getGroups());
    }

    public function testSettersWithEmptyArray()
    {
        $userId = 123;
        $groups = [];

        $userGroup = UserGroup::create($userId)->setGroups($groups);

        $this->assertEquals('UserGroup', $userGroup->getType());
        $this->assertEquals($groups, $userGroup->getGroups());
    }

    /**
     * @expectedException Serato\UserProfileSdk\Exception\InvalidUserGroupMessageException
     */
    public function testSettersWithIncorrectValues()
    {
        $userId = 123;
        $groups = [
            [
                // String is passed for ID instead of integer
                UserGroup::ID => "five",
                UserGroup::NAME => "Group Five"
            ]
        ];
        $userGroup = UserGroup::create($userId)->setGroups($groups);
    }

    /**
     * @expectedException Serato\UserProfileSdk\Exception\InvalidUserGroupMessageException
     */
    public function testSettersWithIncorrectValues2()
    {
        $userId = 123;
        $groups = [
            [
                UserGroup::ID => 5,
                // Integer is passed for NAME instead of string
                UserGroup::NAME => 5
            ]
        ];
        $userGroup = UserGroup::create($userId)->setGroups($groups);
    }

    /**
     * @expectedException Serato\UserProfileSdk\Exception\InvalidUserGroupMessageException
     */
    public function testSettersWithIncorrectValues3()
    {
        $userId = 123;
        $groups = ["invalidData"];
        $userGroup = UserGroup::create($userId)->setGroups($groups);
    }

    /**
     * @expectedException Serato\UserProfileSdk\Exception\InvalidUserGroupMessageException
     */
    public function testSettersWithIncorrectStructure()
    {
        $userId = 123;
        // Invalid array structure
        $groups = [
            [
                UserGroup::ID => 5
            ]
        ];
        $userGroup = UserGroup::create($userId)->setGroups($groups);
    }

    /**
     * @expectedException Serato\UserProfileSdk\Exception\InvalidUserGroupMessageException
     */
    public function testSettersWithIncorrectStructure2()
    {
        $userId = 123;
        // Invalid array structure
        $groups = [
            [
                UserGroup::ID => 5,
                UserGroup::NAME => "Group Five",
                // Invalid key in array
                "InvalidKey" => "someValue"
            ]
        ];
        $userGroup = UserGroup::create($userId)->setGroups($groups);
    }
}
