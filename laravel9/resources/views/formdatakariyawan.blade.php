
@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corporate Employee Registration Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Helvetica Neue', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: #2c3e50;
            line-height: 1.6;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            padding: 50px 60px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)" /></svg>');
            opacity: 0.1;
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .company-logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: #2c3e50;
            font-weight: bold;
        }

        .header h1 {
            font-size: 2.8rem;
            margin-bottom: 15px;
            font-weight: 300;
            letter-spacing: 2px;
        }

        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
            font-weight: 300;
        }

        .form-container {
            padding: 60px;
            background: #fafbfc;
        }

        .progress-bar {
            background: #ecf0f1;
            height: 4px;
            border-radius: 2px;
            margin-bottom: 40px;
            overflow: hidden;
        }

        .progress-fill {
            background: linear-gradient(90deg, #3498db, #2980b9);
            height: 100%;
            width: 0%;
            transition: width 0.3s ease;
        }

        .section {
            background: white;
            margin-bottom: 30px;
            border-radius: 12px;
            border: 1px solid #e1e8ed;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .section-header {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            padding: 25px 35px;
            font-size: 1.4rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .section-icon {
            width: 28px;
            height: 28px;
            fill: white;
        }

        .section-content {
            padding: 35px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        label {
            font-weight: 600;
            color: #34495e;
            margin-bottom: 8px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .required {
            color: #e74c3c;
        }

        input, select, textarea {
            padding: 14px 18px;
            border: 2px solid #bdc3c7;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
            font-family: inherit;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            fill: #7f8c8d;
        }

        .radio-group, .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }

        .radio-item, .checkbox-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            border: 2px solid #ecf0f1;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .radio-item:hover, .checkbox-item:hover {
            border-color: #3498db;
            background: #f8f9fa;
        }

        .radio-item input:checked + label,
        .checkbox-item input:checked + label {
            color: #2980b9;
            font-weight: 600;
        }

        input[type="radio"], input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #3498db;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        .file-upload-area {
            border: 3px dashed #bdc3c7;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .file-upload-area:hover {
            border-color: #3498db;
            background: #ebf3fd;
        }

        .file-upload-area.dragover {
            border-color: #2980b9;
            background: #d6eaf8;
            transform: scale(1.02);
        }

        .file-upload-area input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .upload-icon {
            width: 48px;
            height: 48px;
            fill: #7f8c8d;
            margin-bottom: 15px;
        }

        .file-upload-text {
            color: #7f8c8d;
            font-size: 1rem;
            margin-bottom: 8px;
        }

        .file-upload-hint {
            color: #95a5a6;
            font-size: 0.9rem;
        }

        .file-list {
            margin-top: 15px;
            text-align: left;
        }

        .file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            background: white;
            border: 1px solid #e1e8ed;
            border-radius: 6px;
            margin-bottom: 8px;
        }

        .file-name {
            color: #2c3e50;
            font-weight: 500;
        }

        .file-size {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .remove-file {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
        }

        .form-actions {
            background: #ecf0f1;
            padding: 40px 60px;
            text-align: center;
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 16px 40px;
            border: none;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            min-width: 180px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(52, 152, 219, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: #7f8c8d;
            border: 2px solid #bdc3c7;
        }

        .btn-secondary:hover {
            border-color: #95a5a6;
            color: #2c3e50;
        }

        .validation-message {
            color: #e74c3c;
            font-size: 0.9rem;
            margin-top: 5px;
            display: none;
        }

        .form-group.error input,
        .form-group.error select,
        .form-group.error textarea {
            border-color: #e74c3c;
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
        }

        .form-group.error .validation-message {
            display: block;
        }

        .form-group.success input,
        .form-group.success select,
        .form-group.success textarea {
            border-color: #27ae60;
        }

        .step-indicator {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
            padding: 30px;
            background: white;
            border-radius: 12px;
            border: 1px solid #e1e8ed;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .step.active {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }

        .step.completed {
            background: #27ae60;
            color: white;
        }

        .step-number {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .header {
                padding: 30px 20px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .form-container {
                padding: 30px 20px;
            }

            .section-content {
                padding: 25px 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .radio-group, .checkbox-group {
                grid-template-columns: 1fr;
            }

            .form-actions {
                padding: 30px 20px;
                flex-direction: column;
            }

            .btn {
                width: 100%;
                margin: 5px 0;
            }

            .step-indicator {
                flex-direction: column;
                gap: 15px;
            }

            .step {
                width: 100%;
                justify-content: center;
            }
        }

        .loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-top: 5px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .success-message {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            display: none;
        }

        .tooltip {
            position: relative;
            cursor: help;
        }

        .tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            background: #2c3e50;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 0.8rem;
            white-space: nowrap;
            z-index: 100;
        }

        .tooltip:hover::before {
            content: '';
            position: absolute;
            bottom: 115%;
            left: 50%;
            transform: translateX(-50%);
            border: 5px solid transparent;
            border-top: 5px solid #2c3e50;
            z-index: 100;
        }
    </style>
</head>
<body>
    <div class="loading" id="loading">
        <div class="loading-spinner"></div>
    </div>

    <div class="container">
        <div class="header">
            <div class="header-content">
                <div class="company-logo">
                    <svg viewBox="0 0 24 24" width="40" height="40" fill="currentColor">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
                <h1>Corporate HR System</h1>
                <p>Employee Registration & Data Management</p>
            </div>
        </div>

        <div class="form-container">
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>

            <div class="step-indicator">
                <div class="step active" id="step1">
                    <div class="step-number">1</div>
                    <span>Personal Data</span>
                </div>
                <div class="step" id="step2">
                    <div class="step-number">2</div>
                    <span>Contact Info</span>
                </div>
                <div class="step" id="step3">
                    <div class="step-number">3</div>
                    <span>Employment</span>
                </div>
                <div class="step" id="step4">
                    <div class="step-number">4</div>
                    <span>Education</span>
                </div>
                <div class="step" id="step5">
                    <div class="step-number">5</div>
                    <span>Documents</span>
                </div>
            </div>

            <div class="success-message" id="successMessage">
                <h3>✅ Data Successfully Submitted!</h3>
                <p>Your employee registration has been processed and will be reviewed by HR department.</p>
            </div>

            <form id="employeeForm" novalidate>
                <!-- Personal Data Section -->
                <div class="section">
                    <div class="section-header">
                        <svg class="section-icon" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                        Personal Information
                    </div>
                    <div class="section-content">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="employeeId">Employee ID <span class="required">*</span></label>
                                <input type="text" id="employeeId" name="employeeId" required placeholder="AUTO-GENERATED" readonly style="background: #f8f9fa;">
                            </div>
                            <div class="form-group">
                                <label for="fullName">Full Name <span class="required">*</span></label>
                                <input type="text" id="fullName" name="fullName" required placeholder="Enter full legal name">
                                <div class="validation-message">Full name is required</div>
                            </div>
                            <div class="form-group">
                                <label for="nik">National ID (NIK) <span class="required">*</span></label>
                                <input type="text" id="nik" name="nik" pattern="[0-9]{16}" maxlength="16" required placeholder="16-digit ID number">
                                <div class="validation-message">NIK must be exactly 16 digits</div>
                            </div>
                            <div class="form-group">
                                <label for="birthPlace">Place of Birth <span class="required">*</span></label>
                                <input type="text" id="birthPlace" name="birthPlace" required placeholder="City of birth">
                                <div class="validation-message">Place of birth is required</div>
                            </div>
                            <div class="form-group">
                                <label for="birthDate">Date of Birth <span class="required">*</span></label>
                                <input type="date" id="birthDate" name="birthDate" required>
                                <div class="validation-message">Valid birth date is required</div>
                            </div>
                            <div class="form-group">
                                <label>Gender <span class="required">*</span></label>
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input type="radio" id="male" name="gender" value="male" required>
                                        <label for="male">Male</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" id="female" name="gender" value="female" required>
                                        <label for="female">Female</label>
                                    </div>
                                </div>
                                <div class="validation-message">Please select gender</div>
                            </div>
                            <div class="form-group">
                                <label for="maritalStatus">Marital Status</label>
                                <select id="maritalStatus" name="maritalStatus">
                                    <option value="">Select Status</option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="divorced">Divorced</option>
                                    <option value="widowed">Widowed</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="religion">Religion</label>
                                <select id="religion" name="religion">
                                    <option value="">Select Religion</option>
                                    <option value="islam">Islam</option>
                                    <option value="christian">Christian</option>
                                    <option value="catholic">Catholic</option>
                                    <option value="hindu">Hindu</option>
                                    <option value="buddha">Buddha</option>
                                    <option value="confucian">Confucian</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group full-width">
                                <label for="address">Full Address <span class="required">*</span></label>
                                <textarea id="address" name="address" required placeholder="Complete address including postal code"></textarea>
                                <div class="validation-message">Complete address is required</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="section">
                    <div class="section-header">
                        <svg class="section-icon" viewBox="0 0 24 24">
                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                        </svg>
                        Contact Information
                    </div>
                    <div class="section-content">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="phone">Phone Number <span class="required">*</span></label>
                                <input type="tel" id="phone" name="phone" required placeholder="+62 xxx xxxx xxxx" pattern="[+]?[0-9]{10,15}">
                                <div class="validation-message">Valid phone number is required</div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address <span class="required">*</span></label>
                                <input type="email" id="email" name="email" required placeholder="employee@company.com">
                                <div class="validation-message">Valid email address is required</div>
                            </div>
                            <div class="form-group">
                                <label for="emergencyContact">Emergency Contact Name</label>
                                <input type="text" id="emergencyContact" name="emergencyContact" placeholder="Full name">
                            </div>
                            <div class="form-group">
                                <label for="emergencyPhone">Emergency Contact Phone</label>
                                <input type="tel" id="emergencyPhone" name="emergencyPhone" placeholder="+62 xxx xxxx xxxx">
                            </div>
                            <div class="form-group">
                                <label for="emergencyRelation">Relationship to Emergency Contact</label>
                                <select id="emergencyRelation" name="emergencyRelation">
                                    <option value="">Select Relationship</option>
                                    <option value="parent">Parent</option>
                                    <option value="spouse">Spouse</option>
                                    <option value="sibling">Sibling</option>
                                    <option value="child">Child</option>
                                    <option value="friend">Friend</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Employment Information Section -->
                <div class="section">
                    <div class="section-header">
                        <svg class="section-icon" viewBox="0 0 24 24">
                            <path d="M20 6h-2.18c.11-.31.18-.65.18-1a2.996 2.996 0 0 0-5.5-1.65l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2z"/>
                        </svg>
                        Employment Details
                    </div>
                    <div class="section-content">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="startDate">Start Date <span class="required">*</span></label>
                                <input type="date" id="startDate" name="startDate" required>
                                <div class="validation-message">Start date is required</div>
                            </div>
                            <div class="form-group">
                                <label for="department">Department <span class="required">*</span></label>
                                <select id="department" name="department" required>
                                    <option value="">Select Department</option>
                                    <option value="human-resources">Human Resources</option>
                                    <option value="finance">Finance & Accounting</option>
                                    <option value="information-technology">Information Technology</option>
                                    <option value="marketing">Marketing & Communications</option>
                                    <option value="sales">Sales</option>
                                    <option value="operations">Operations</option>
                                    <option value="production">Production</option>
                                    <option value="research-development">Research & Development</option>
                                    <option value="legal">Legal</option>
                                    <option value="administration">Administration</option>
                                </select>
                                <div class="validation-message">Please select a department</div>
                            </div>
                            <div class="form-group">
                                <label for="position">Position/Job Title <span class="required">*</span></label>
                                <input type="text" id="position" name="position" required placeholder="e.g., Senior Software Engineer">
                                <div class="validation-message">Position is required</div>
                            </div>
                            <div class="form-group">
                                <label for="employeeLevel">Employee Level</label>
                                <select id="employeeLevel" name="employeeLevel">
                                    <option value="">Select Level</option>
                                    <option value="intern">Intern</option>
                                    <option value="junior">Junior Level</option>
                                    <option value="mid">Mid Level</option>
                                    <option value="senior">Senior Level</option>
                                    <option value="lead">Team Lead</option>
                                    <option value="manager">Manager</option>
                                    <option value="senior-manager">Senior Manager</option>
                                    <option value="director">Director</option>
                                    <option value="vice-president">Vice President</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="employmentType">Employment Type <span class="required">*</span></label>
                                <select id="employmentType" name="employmentType" required>
                                    <option value="">Select Type</option>
                                    <option value="permanent">Permanent Employee</option>
                                    <option value="contract">Contract Employee</option>
                                    <option value="intern">Intern</option>
                                    <option value="consultant">Consultant</option>
                                    <option value="freelance">Freelance</option>
                                </select>
                                <div class="validation-message">Please select employment type</div>
                            </div>
                            <div class="form-group">
                                <label for="workLocation">Work Location</label>
                                <select id="workLocation" name="workLocation">
                                    <option value="">Select Location</option>
                                    <option value="head-office">Head Office</option>
                                    <option value="branch-jakarta">Branch - Jakarta</option>
                                    <option value="branch-surabaya">Branch - Surabaya</option>
                                    <option value="branch-bandung">Branch - Bandung</option>
                                    <option value="remote">Remote</option>
                                    <option value="hybrid">Hybrid</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="baseSalary">Base Salary (IDR)</label>
                                <input type="number" id="baseSalary" name="baseSalary" min="0" placeholder="Monthly base salary">
                            </div>
 <div class="form-group">
                                <label for="reportingManager">Reporting Manager</label>
                                <input type="text" id="reportingManager" name="reportingManager" placeholder="Direct supervisor name">
                            </div>
                            <div class="form-group">
                                <label for="employeeStatus">Employee Status</label>
                                <select id="employeeStatus" name="employeeStatus">
                                    <option value="">Select Status</option>
                                    <option value="active">Active</option>
                                    <option value="on-leave">On Leave</option>
                                    <option value="resigned">Resigned</option>
                                    <option value="terminated">Terminated</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Education Section -->
                <div class="section">
                    <div class="section-header">
                        <svg class="section-icon" viewBox="0 0 24 24">
                            <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zm0 13.09L3.74 10.5 12 6.09l8.26 4.41L12 16.09z"/>
                        </svg>
                        Education Background
                    </div>
                    <div class="section-content">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="highestEducation">Highest Education <span class="required">*</span></label>
                                <select id="highestEducation" name="highestEducation" required>
                                    <option value="">Select Education</option>
                                    <option value="sma">SMA/SMK</option>
                                    <option value="d3">Diploma (D3)</option>
                                    <option value="s1">Bachelor (S1)</option>
                                    <option value="s2">Master (S2)</option>
                                    <option value="s3">Doctorate (S3)</option>
                                    <option value="other">Other</option>
                                </select>
                                <div class="validation-message">Please select education</div>
                            </div>
                            <div class="form-group">
                                <label for="schoolName">School/University Name <span class="required">*</span></label>
                                <input type="text" id="schoolName" name="schoolName" required placeholder="Institution name">
                                <div class="validation-message">School/University name is required</div>
                            </div>
                            <div class="form-group">
                                <label for="major">Major/Field of Study</label>
                                <input type="text" id="major" name="major" placeholder="e.g., Computer Science">
                            </div>
                            <div class="form-group">
                                <label for="graduationYear">Year of Graduation</label>
                                <input type="number" id="graduationYear" name="graduationYear" min="1900" max="2099" placeholder="e.g., 2022">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents Section -->
                <div class="section">
                    <div class="section-header">
                        <svg class="section-icon" viewBox="0 0 24 24">
                            <path d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm7 7V3.5L18.5 9H13z"/>
                        </svg>
                        Upload Documents
                    </div>
                    <div class="section-content">
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label for="documents">Upload Documents <span class="required">*</span></label>
                                <div class="file-upload-area" id="fileUploadArea">
                                    <svg class="upload-icon" viewBox="0 0 24 24">
                                        <path d="M19 15v4a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-4H2l10-9 10 9h-3zm-7 4h4v-6h3l-5-4.55L8 13h3v6z"/>
                                    </svg>
                                    <div class="file-upload-text">Drag & drop files here or click to select</div>
                                    <div class="file-upload-hint">Accepted: PDF, JPG, PNG, DOCX. Max 5MB each.</div>
                                    <input type="file" id="documents" name="documents[]" multiple accept=".pdf,.jpg,.jpeg,.png,.docx">
                                    <div class="file-list" id="fileList"></div>
                                </div>
                                <div class="validation-message" id="fileValidationMessage">Please upload at least one document</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" id="prevBtn">Previous</button>
                    <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn" style="display:none;">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Example: Multi-step form navigation, file upload preview, and validation
        // (Implement your JS logic here as needed)
    </script>
</body>
</html>
@endsection