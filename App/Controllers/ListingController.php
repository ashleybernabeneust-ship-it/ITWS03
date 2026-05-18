<?php
namespace App\Controllers;

use Framework\Database;
use Framework\Session;
use Framework\Authorization;
use App\Controllers\ErrorController;

class ListingController {
    protected $db;

    public function __construct() {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function index($params = []) {
        $listings = $this->db->Query(
            "SELECT * FROM listings ORDER BY created_at DESC"
        )->fetchAll();

        loadView('Listings/index', ['listings' => $listings]);
    }

    public function search($params = []) {
        $keywords = trim($_GET['keywords'] ?? '');
        $location = trim($_GET['location'] ?? '');

        if ($keywords === '' && $location === '') {
            $this->index();
            return;
        }

        $query = "SELECT * FROM listings WHERE 1=1";
        $params = [];

        if ($keywords !== '') {
            $query .= " AND (title LIKE :search OR description LIKE :search OR tags LIKE :search)";
            $params['search'] = "%{$keywords}%";
        }

        if ($location !== '') {
            $query .= " AND (city LIKE :location OR state LIKE :location OR address LIKE :location)";
            $params['location'] = "%{$location}%";
        }

        $query .= " ORDER BY created_at DESC";

        $listings = $this->db->Query($query, $params)->fetchAll();

        loadView('Listings/index', [
            'listings' => $listings,
            'keywords' => $keywords,
            'location' => $location
        ]);
    }

    protected function validateListingData() {
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'salary' => trim($_POST['salary'] ?? ''),
            'requirements' => trim($_POST['requirements'] ?? ''),
            'benefits' => trim($_POST['benefits'] ?? ''),
            'tags' => trim($_POST['tags'] ?? ''),
            'company' => trim($_POST['company'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'city' => trim($_POST['city'] ?? ''),
            'state' => trim($_POST['state'] ?? ''),
            'phone' => trim($_POST['phone'] ?? '')
        ];

        $errors = [];

        if ($data['title'] === '') {
            $errors[] = 'Job title is required.';
        }
        if ($data['description'] === '') {
            $errors[] = 'Job description is required.';
        }
        if ($data['salary'] === '' || !is_numeric($data['salary'])) {
            $errors[] = 'Salary is required and must be a number.';
        }
        if ($data['company'] === '') {
            $errors[] = 'Company name is required.';
        }
        if ($data['city'] === '') {
            $errors[] = 'City is required.';
        }
        if ($data['state'] === '') {
            $errors[] = 'State is required.';
        }

        return ['data' => $data, 'errors' => $errors];
    }

    public function create($params = []) {
        loadView('Listings/create', [
            'listing' => (object)[],
            'errors' => []
        ]);
    }

    public function store($params = []) {
        Session::start();
        $validation = $this->validateListingData();

        if (!empty($validation['errors'])) {
            loadView('Listings/create', [
                'errors' => $validation['errors'],
                'listing' => (object) $validation['data']
            ]);
            return;
        }

        $user = Session::get('user');
        if ($user === null) {
            ErrorController::unauthorized();
            return;
        }

        $insertData = $validation['data'];
        $insertData['user_id'] = $user['id'];

        $this->db->Query(
            "INSERT INTO listings (title, description, salary, requirements, benefits, tags, company, address, city, state, phone, user_id) VALUES (:title, :description, :salary, :requirements, :benefits, :tags, :company, :address, :city, :state, :phone, :user_id)",
            $insertData
        );

        Session::setFlashMessage('success_message', 'Listing created successfully.');
        redirect('/listings');
    }

    public function edit($params = []) {
        $listing = $this->findListing($params['id'] ?? null);
        if ($listing === null) {
            ErrorController::notFound();
            return;
        }

        if (!Authorization::isOwner($listing->user_id)) {
            ErrorController::unauthorized();
            return;
        }

        loadView('Listings/edit', ['listing' => $listing, 'errors' => []]);
    }

    public function update($params = []) {
        Session::start();
        $listing = $this->findListing($params['id'] ?? null);
        if ($listing === null) {
            ErrorController::notFound();
            return;
        }

        if (!Authorization::isOwner($listing->user_id)) {
            ErrorController::unauthorized();
            return;
        }

        $validation = $this->validateListingData();
        if (!empty($validation['errors'])) {
            loadView('Listings/edit', [
                'listing' => (object) array_merge((array) $listing, $validation['data']),
                'errors' => $validation['errors']
            ]);
            return;
        }

        $this->db->Query(
            "UPDATE listings SET title = :title, description = :description, salary = :salary, requirements = :requirements, benefits = :benefits, tags = :tags, company = :company, address = :address, city = :city, state = :state, phone = :phone WHERE id = :id",
            array_merge($validation['data'], ['id' => $listing->id])
        );

        Session::setFlashMessage('success_message', 'Listing updated successfully.');
        redirect('/listings/' . $listing->id);
    }

    public function destroy($params = []) {
        Session::start();
        $listing = $this->findListing($params['id'] ?? null);
        if ($listing === null) {
            ErrorController::notFound();
            return;
        }

        if (!Authorization::isOwner($listing->user_id)) {
            ErrorController::unauthorized();
            return;
        }

        $this->db->Query("DELETE FROM listings WHERE id = :id", ['id' => $listing->id]);

        Session::setFlashMessage('success_message', 'Listing deleted successfully.');
        redirect('/listings');
    }

    public function show($params = []) {
        $listing = $this->findListing($params['id'] ?? null);
        if ($listing === null) {
            ErrorController::notFound();
            return;
        }

        loadView('Listings/show', ['listing' => $listing]);
    }

    protected function findListing($id) {
        if ($id === null) {
            return null;
        }

        return $this->db->Query("SELECT * FROM listings WHERE id = :id", ['id' => $id])->fetch();
    }
}
?>