<?php

namespace Tests\Loader;

use BravePickle\AliceLaravel\Loader\ModelLoader;
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
            ->willReturn($expectedReturn)
        ;

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
            ->willReturn($expectedReturn)
        ;

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
            ]
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
            ->willReturn($expectedReturn)
        ;

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
            ]
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
            ->willReturn($expectedReturn)
        ;

        $modelLoader = new ModelLoader($nativeLoader);
        $this->assertEquals([], $modelLoader->getContext(), 'Context values mismatch');
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
    public function testLoadUsers(): void
    {
        $data = [
            User::class => [
                'user{1..10}' => [
                    'username' => '<username()>',
                ],
            ]
        ];
        $parameters = ['prefix' => 'Don.', ];
//        $objects = [];

//        $expectedParameters = $parameters;
//        $expectedReturn = new ObjectSet(new ParameterBag(), new ObjectBag());
//
//        $nativeLoader = $this->createMock(NativeLoader::class);
//        $nativeLoader->expects($this->once())
//            ->method('loadData')
//            ->with(
//                $this->equalTo($data),
//                $this->equalTo($expectedParameters),
//                $this->equalTo($objects),
//            )
//            ->willReturn($expectedReturn)
//        ;

//        $modelLoader = new ModelLoader($nativeLoader);
        $modelLoader = new ModelLoader();
//        $this->assertEquals([], $modelLoader->getContext(), 'Context values mismatch');
//        $actualReturn = $modelLoader->loadData($data, $parameters, $objects);
        $sep = DIRECTORY_SEPARATOR;
        $actualReturn = $modelLoader->loadFile(
            __DIR__ . $sep . '..' . $sep . 'resources' . $sep . 'users.basic.yaml',
            $parameters
        );

//        xdebug_var_dump(json_encode($actualReturn, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        xdebug_var_dump(json_encode($actualReturn->getObjects(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        xdebug_var_dump($actualReturn->getParameters());
//        xdebug_var_dump($actualReturn->getObjects());
        die("\n" . __METHOD__ . ':' . __FILE__ . ':' . __LINE__);
//        $this->assertEquals($expectedReturn, $actualReturn);
    }
}
