<?php

namespace Tests\Unit;

use App\Category;
use App\Note;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ApiNoteTest extends TestCase {
	use DatabaseTransactions;

	protected $note = 'This is a note';
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function test_list_notes() {
		$category = factory(Category::class)->create();

		$notes = factory(Note::class)->times(2)->create([
			'category_id' => $category->id,
		]);

		$this->get('api/notes')
			->assertStatus(200)
			->assertExactJson($notes->toArray());
	}

	public function test_can_create_a_note() {
		$category = factory(Category::class)->create();

		$this->post('api/notes', [
			'note' => $this->note,
			'category_id' => $category->id,
		])
			->assertExactJson([
				'success' => true,
				'note' => Note::first()->toArray(),
			]);

		$this->assertDatabaseHas('notes', [
			'note' => $this->note,
			'category_id' => $category->id,
		]);
	}

	public function test_validation_when_creating_a_note() {
		$this->post('api/notes', [
			'note' => '',
			'category_id' => 100,
		], ['Accept' => 'application/json'])
			->assertExactJson([
				'success' => false,
				'errors' => [
					'The note field is required.',
					'The selected category is invalid.',
				],
			]);

		$this->assertDatabaseMissing('notes', [
			'note' => '',
		]);
	}

	public function test_can_update_a_note() {
		$category = factory(Category::class)->create();

		$anotherCategory = factory(Category::class)->create();

		$note = factory(Note::class)->create([
			'category_id' => $category->id,
		]);

		$this->put("api/notes/{$note->id}", [
			'note' => 'Updated note',
			'category_id' => $anotherCategory->id,
		])
			->assertExactJson([
				'success' => true,
				'note' => [
					'id' => $note->id,
					'note' => 'Updated note',
					'category_id' => $anotherCategory->id,
				],
			]);

		$this->assertDatabaseHas('notes', [
			'note' => 'Updated note',
			'category_id' => $anotherCategory->id,
		]);
	}

	public function test_validation_when_updating_a_note() {
		$category = factory(Category::class)->create();

		$note = factory(Note::class)->create([
			'category_id' => $category->id,
		]);

		$this->put("api/notes/{$note->id}", [
			'note' => '',
			'category_id' => 100,
		], ['Accept' => 'application/json'])
			->assertExactJson([
				'success' => false,
				'errors' => [
					'The note field is required.',
					'The selected category is invalid.',
				],
			]);

		$this->assertDatabaseMissing('notes', [
			'id' => $note->id,
			'note' => '',
		]);
	}

	public function test_can_delete_a_note() {
		$note = factory(Note::class)->create();

		$this->delete("api/notes/{$note->id}", [], ['Accept' => 'application/json'])
			->assertExactJson([
				'success' => true,
			]);

		$this->assertDatabaseMissing('notes', [
			'id' => $note->id,
		]);
	}
}
