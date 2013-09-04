<?php
/**
 * Created by JetBrains PhpStorm.
 * User: witoo
 * Date: 9/2/13
 * Time: 2:35 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Witooh\Validator\Test;

use Mockery as m;
use Way\Tests\Assert;
use Witooh\Validator\ResolverContainer;

class ResolverContainerTest extends \PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        m::close();
    }

    public function testNew()
    {
        $resolverContainer = new ResolverContainer();

        Assert::instance('Witooh\Validator\IResolverContainer', $resolverContainer);
    }

    public function testAddAndHas()
    {
        //Act
        $resolverContainer = new ResolverContainer();
        $resolverContainer->add('a');
        $resolverContainer->add('b');

        //Assert
        Assert::assertTrue($resolverContainer->has('a'));
        Assert::assertTrue($resolverContainer->has('b'));
        Assert::assertFalse($resolverContainer->has('c'));
    }

    public function testResolve()
    {
        //Arrange
        $a = m::mock('Illuminate\Validation\Validator');
        $b = m::mock('Illuminate\Validation\Validator');
        $resolvers = array(get_class($a), get_class($b));

        //Act
        $resolverContainer = new ResolverContainer();
//        $resolverContainer->resolve($resolvers);


    }
}