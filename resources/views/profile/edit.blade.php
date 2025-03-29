@extends('frontend.Master')
@section('content')
<style>


/* Container */
.container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 30px 20px;
}

/* Profile Section */
.profile-section {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

.card {
    background-color: #ffffff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

.card-header {
    padding: 20px;
    background-color: #f5f7fa;
    border-bottom: 1px solid #e1e4e8;
}

.card-header h2 {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
}

.card-header p {
    font-size: 14px;
    color: #666;
}

.card-body {
    padding: 20px;
}

.card-body input,
.card-body select,
.card-body textarea {
    width: 100%;
    padding: 12px 18px;
    margin: 10px 0;
    border: 1px solid #dcdfe4;
    border-radius: 6px;
    font-size: 16px;
    transition: all 0.3s ease;
}

.card-body input:focus,
.card-body select:focus,
.card-body textarea:focus {
    border-color: rgb(147, 7, 231);
    outline: none;
}

/* Button Styles */
.card-body button {
    padding: 12px 20px;
    font-size: 16px;
    background-color: rgb(147, 7, 231);
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.card-body button:hover {
    background-color: #3579e4;
}

.card-body button:disabled {
    background-color: #a0c3f2;
    cursor: not-allowed;
}

/* Responsive Design */
@media screen and (min-width: 768px) {
    .profile-section {
        grid-template-columns: 1fr 1fr;
    }

    .card {
        padding: 20px;
    }
}

@media screen and (max-width: 768px) {
    .container {
        padding: 15px;
    }

    .card-header h2 {
        font-size: 20px;
    }

    .card-body {
        padding: 15px;
    }
}
</style>
    <div class="container">
        <div class="profile-section">
            <!-- Profile Information Section -->
            <div class="card">
                <div class="card-header">
                    <h2>Update Profile Information</h2>
                    <p>Update your personal details here.</p>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Change Password Section -->
            <div class="card">
                <div class="card-header">
                    <h2>Change Password</h2>
                    <p>For security, you can update your password here.</p>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
@endsection
