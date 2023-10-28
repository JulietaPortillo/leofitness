<?php
namespace App\Lubus;
class Constants
{
// Member Status
    const InActive = 0;
    const Active = 1;
    const Archive = 2;

// Enquiry Status
    const Lost = 0;
    const Lead = 1;
    const Member = 2;

//Follow Up Status
    const Pending = 0;
    const Done = 1;

//Follow Up By
    const Call = 0;
    const SMS = 1;
    const Personal = 2;

// File PATHS
    const UserProfilePhoto = '/assets/img/profile';
    const UserProofPhoto = '/assets/img/proof';
    const StaffPhoto = '/assets/img/staff';
    const GymLogo = '/assets/img/gym';

    const UserProfilePhoto = 'profile_';
    const UserProofPhoto = 'proof_';
    const StaffPhoto = 'staff_';
// Payment status
    const Unpaid = 0;
    const Paid = 1;
    const Partial = 2;
    const Overpaid = 3;

// Cheque status
    const Recieved = 0;
    const Deposited = 1;
    const Cleared = 2;
    const Bounced = 3;
    const Reissued = 4;
// Invoice Items
    const admission = 'Admission';
    const gymSubscription = 'Gym Subscription';
    const taxes = 'Taxes';
//subscription
    const Expired = 0;
    const onGoing = 1;
    const renewed = 2;
    const cancelled = 3;

//numbering mode
    const Manual = 0;
    const Auto = 1;

//Payment mode
    const Cheque = 0;
    const Cash = 1;
}
