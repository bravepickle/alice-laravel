<?php

namespace Tests\Loader;

use BravePickle\AliceLaravel\Loader\ModelLoader;
use Illuminate\Contracts\Support\Arrayable;
use Nelmio\Alice\Loader\NativeLoader;
use Nelmio\Alice\ObjectBag;
use Nelmio\Alice\ObjectSet;
use Nelmio\Alice\ParameterBag;
use Nelmio\Alice\Throwable\LoadingThrowable;
use PHPUnit\Framework\TestCase;
use stdClass;
use Tests\Models\User;

class ModelLoaderTest extends TestCase
{
    /**
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::loadFile
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::__construct
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::getContext
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::mergeParameters
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::withContext
     * @throws LoadingThrowable
     */
    public function testLoadFile(): void
    {
        $file = 'test.fixtures.yaml';
        $parameters = ['lorem' => 'ipsum', 'foo' => 'bar'];
        $objects = ['now' => new \DateTime()];

        $commonParameters = ['global' => true, 'foo' => 'baz'];
        $context = ['parameters' => $commonParameters];
        $expectedParameters = ['global' => true, 'lorem' => 'ipsum', 'foo' => 'bar'];
        $expectedReturn = new ObjectSet(new ParameterBag(), new ObjectBag());

        $nativeLoader = $this->createMock(NativeLoader::class);
        $nativeLoader->expects($this->once())
            ->method('loadFile')
            ->with(
                $this->equalTo($file),
                $this->equalTo($expectedParameters),
                $this->equalTo($objects),
            )
            ->willReturn($expectedReturn);

        $modelLoader = (new ModelLoader($nativeLoader))->withContext($context);
        $this->assertEquals($context, $modelLoader->getContext(), 'Context values mismatch');
        $actualReturn = $modelLoader->loadFile($file, $parameters, $objects);
        $this->assertEquals($expectedReturn, $actualReturn);
    }

    /**
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::loadFiles
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::__construct
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::getContext
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::mergeParameters
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::withContext
     * @throws LoadingThrowable
     */
    public function testLoadFiles(): void
    {
        $files = ['test.fixtures.yaml', 'test2.fixtures.yaml'];
        $parameters = ['lorem' => 'ipsum', 'foo' => 'bar'];
        $objects = ['now' => new \DateTime()];

        $commonParameters = ['global' => true, 'foo' => 'baz'];
        $context = ['parameters' => $commonParameters];
        $expectedParameters = ['global' => true, 'lorem' => 'ipsum', 'foo' => 'bar'];
        $expectedReturn = new ObjectSet(new ParameterBag(), new ObjectBag());

        $nativeLoader = $this->createMock(NativeLoader::class);
        $nativeLoader->expects($this->once())
            ->method('loadFiles')
            ->with(
                $this->equalTo($files),
                $this->equalTo($expectedParameters),
                $this->equalTo($objects),
            )
            ->willReturn($expectedReturn);

        $modelLoader = (new ModelLoader($nativeLoader))->withContext($context);
        $this->assertEquals($context, $modelLoader->getContext(), 'Context values mismatch');
        $actualReturn = $modelLoader->loadFiles($files, $parameters, $objects);
        $this->assertEquals($expectedReturn, $actualReturn);
    }

    /**
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::loadData
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::__construct
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::getContext
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::mergeParameters
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::withContext
     * @throws LoadingThrowable
     */
    public function testLoadData(): void
    {
        $data = [
            stdClass::class => [
                'user{1..10}' => [
                    'username' => '<username()>',
                    'fullname' => '<firstName()> <lastName()>',
                    'birthDate' => '<date_create()>',
                    'email' => '<email()>',
                    'favoriteNumber' => '50%? <numberBetween(1, 200)>',
                ],
            ],
        ];
        $parameters = ['lorem' => 'ipsum', 'foo' => 'bar'];
        $objects = ['now' => new \DateTime()];

        $commonParameters = ['global' => true, 'foo' => 'baz'];
        $context = ['parameters' => $commonParameters];
        $expectedParameters = ['global' => true, 'lorem' => 'ipsum', 'foo' => 'bar'];
        $expectedReturn = new ObjectSet(new ParameterBag(), new ObjectBag());

        $nativeLoader = $this->createMock(NativeLoader::class);
        $nativeLoader->expects($this->once())
            ->method('loadData')
            ->with(
                $this->equalTo($data),
                $this->equalTo($expectedParameters),
                $this->equalTo($objects),
            )
            ->willReturn($expectedReturn);

        $modelLoader = (new ModelLoader($nativeLoader))->withContext($context);
        $this->assertEquals($context, $modelLoader->getContext(), 'Context values mismatch');
        $actualReturn = $modelLoader->loadData($data, $parameters, $objects);
        $this->assertEquals($expectedReturn, $actualReturn);
    }

    /**
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::loadData
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::__construct
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::getContext
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::mergeParameters
     * @throws LoadingThrowable
     */
    public function testLoadDataWithoutContext(): void
    {
        $data = [
            stdClass::class => [
                'user{1..10}' => [
                    'username' => '<username()>',
                ],
            ],
        ];
        $parameters = ['lorem' => 'ipsum', 'foo' => 'bar'];
        $objects = ['now' => new \DateTime()];

        $expectedParameters = $parameters;
        $expectedReturn = new ObjectSet(new ParameterBag(), new ObjectBag());

        $nativeLoader = $this->createMock(NativeLoader::class);
        $nativeLoader->expects($this->once())
            ->method('loadData')
            ->with(
                $this->equalTo($data),
                $this->equalTo($expectedParameters),
                $this->equalTo($objects),
            )
            ->willReturn($expectedReturn);

        $modelLoader = new ModelLoader($nativeLoader);
        $this->assertEquals([], $modelLoader->getContext(), 'Context values mismatch');
        $actualReturn = $modelLoader->loadData($data, $parameters, $objects);
        $this->assertEquals($expectedReturn, $actualReturn);
    }

    /**
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::loadData
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::loadFile
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::__construct
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::getContext
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::mergeParameters
     * @throws LoadingThrowable
     */
    public function testLoadUsers(): void
    {
        $data = [
            'parameters' => ['foo' => 'bar'],
            User::class => [
                'user{1..2}' => [
                    'id' => '<current()>',
                    'username' => '<username()>',
                    'name' => '<{prefix}> <name()> <{foo}> <{suffix}>',
                    'email' => '<email()>',
                ],
            ],
        ];
        $parameters = ['prefix' => 'Don.',];
        $modelLoader = new ModelLoader();
        $subReturn = $modelLoader->loadFile(
            $this->getResourcesPath().'users.basic.yaml',
            $parameters
        );

        $actualReturn = $modelLoader->loadData(
            $data,
            array_merge($parameters, $subReturn->getParameters()),
            $subReturn->getObjects()
        );

        $expected = [
            'admin1' => [
                'id' => 101,
                'username' => 'admin1',
                'name' => 'Don. Mr. Monty Watsica Foo',
                'email' => 'zprosacco@hotmail.com',
            ],
            'admin2' => [
                'id' => 102,
                'username' => 'admin2',
                'name' => 'Don. Terence Moen I Foo',
                'email' => 'gordon93@yahoo.com',
            ],
            'admin3' => [
                'id' => 103,
                'username' => 'admin3',
                'name' => 'Don. Harmon Hahn II Foo',
                'email' => 'lynch.nikki@hotmail.com',
            ],
            'user1' => [
                'id' => 1,
                'username' => 'terry.johns',
                'name' => 'Don. Ivy Mann bar Foo',
                'email' => 'fschmeler@gmail.com',
            ],
            'user2' => [
                'id' => 2,
                'username' => 'celia68',
                'name' => 'Don. Maximillian Larson bar Foo',
                'email' => 'vtremblay@hotmail.com',
            ],
        ];

        $actual = [];
        foreach ($actualReturn->getObjects() as $key => $object) {
            $actual[$key] = $object instanceof Arrayable ? $object->toArray() : $object;
        }

        $this->assertEquals($expected, $actual, 'Parsed objects not matched');
        $this->assertEquals(
            [
                'prefix' => 'Don.',
                'suffix' => 'Foo',
                'foo' => 'bar',
            ],
            $actualReturn->getParameters()
        );
    }

    /**
     * @return string
     */
    protected function getResourcesPath(): string
    {
        return __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR;
    }

    /**
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::loadFile
     * @covers \BravePickle\AliceLaravel\Loader\ModelLoader::mergeParameters
     * @throws LoadingThrowable
     */
    public function testLoadCategories(): void
    {
        $modelLoader = new ModelLoader();
        $actualReturn = $modelLoader->loadFile($this->getResourcesPath().'categories.yaml');

        $expected = [
            'cat1' => [
                'id' => 1,
                'name' => 'Root',
                'parent_id' => null,
            ],
            'cat2' => [
                'id' => 2,
                'name' => 'Leaf',
                'parent_id' => 3,
            ],
            'cat3' => [
                'id' => 3,
                'name' => 'Sub',
                'parent_id' => 1,
            ],
        ];

        $actual = [];
        foreach ($actualReturn->getObjects() as $key => $object) {
            $actual[$key] = $object instanceof Arrayable ? $object->toArray() : $object;
        }

        $this->assertEquals($expected, $actual, 'Parsed objects not matched');
    }
}
