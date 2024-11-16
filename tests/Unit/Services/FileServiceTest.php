<?php

namespace Tests\Unit\Services;

use App\Services\Contracts\FileServiceContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileServiceTest extends TestCase
{
    const FILE_NAME = 'image.png';
    protected FileServiceContract $fileService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fileService = app(FileServiceContract::class);
        Storage::fake('public');
    }

    public function test_it_uploads_valid_file(): void
    {
        $uploadedFile = $this->uploadFile();

        $this->assertTrue(Storage::has($uploadedFile));
        $this->assertEquals(Storage::getVisibility($uploadedFile), 'public');
        $this->assertNotEquals($uploadedFile, self::FILE_NAME);
    }

    public function test_it_uploads_valid_file_with_additional_path(): void
    {
        $uploadedFile = $this->uploadFile(additionalPath: 'products/test');

        $this->assertTrue(Storage::has($uploadedFile));
        $this->assertEquals(Storage::getVisibility($uploadedFile), 'public');
        $this->assertStringContainsString('products/test', $uploadedFile);
    }

    public function test_it_uploads_two_files_with_the_same_name(): void
    {
        $uploadedFile1 = $this->uploadFile(additionalPath: 'products/test');
        $uploadedFile2 = $this->uploadFile(additionalPath: 'products/test');

        $this->assertTrue(Storage::has($uploadedFile1));
        $this->assertTrue(Storage::has($uploadedFile2));
        $this->assertEquals(Storage::getVisibility($uploadedFile1), 'public');
        $this->assertEquals(Storage::getVisibility($uploadedFile2), 'public');
        $this->assertStringContainsString('products/test', $uploadedFile1);
        $this->assertStringContainsString('products/test', $uploadedFile2);
    }

    public function test_it_removes_file(): void
    {
        $path = $this->uploadFile(additionalPath: 'products/test');

        $this->assertTrue(Storage::has($path));
        $this->fileService->delete($path);
        $this->assertFalse(Storage::has($path));
    }

    public function test_it_removes_directory_if_it_empty(): void
    {
        $dir = 'products/test';
        $path = $this->uploadFile(additionalPath: $dir);

        $this->assertTrue(Storage::has($dir));
        $this->fileService->delete($path);
        $this->assertFalse(Storage::has($dir));
    }

    protected function uploadFile(?string $fileName = null, string $additionalPath = ''): string
    {
        $file = UploadedFile::fake()->image($fileName ?? self::FILE_NAME);

        return $this->fileService->upload($file, $additionalPath);
    }
}
