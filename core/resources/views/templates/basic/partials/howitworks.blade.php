<div style="font-family: Arial, sans-serif; padding: 20px;">
    <h2 style="margin-bottom: 10px;">How It Works</h2>
    <div class="tabs" style="display: flex; gap: 20px; margin-bottom: 20px; cursor: pointer;">
        <div class="tab active" onclick="showTab('donor')" style="padding: 10px 20px; background: #168e6a; color: white; border-radius: 5px;">Donor</div>
        <div class="tab" onclick="showTab('ngo')" style="padding: 10px 20px; background: #fbb03b; color: white; border-radius: 5px;">NGO</div>
    </div>
    <div id="donor" class="tab-content">
        <ol>
            <li>Sign up as a donor.</li>
            <li>Browse causes and NGOs.</li>
            <li>Donate securely and easily.</li>
            <li>Track the impact of your donation.</li>
        </ol>
    </div>
    <div id="ngo" class="tab-content" style="display:none;">
        <ol>
            <li>Register your NGO profile.</li>
            <li>List projects and needs.</li>
            <li>Receive donations directly.</li>
            <li>Update donors on impact.</li>
        </ol>
    </div>
</div>

<script>
    function showTab(tabName) {
        var tabs = document.querySelectorAll('.tab');
        var contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => tab.classList.remove('active'));
        contents.forEach(content => content.style.display = 'none');

        document.querySelector('.tab[onclick="showTab(\'' + tabName + '\')"]').classList.add('active');
        document.getElementById(tabName).style.display = 'block';
    }
</script>

<style>
    .tab.active {
        opacity: 1;
        filter: brightness(1.1);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .tab:hover {
        filter: brightness(1.1);
    }
    ol {
        padding-left: 20px;
    }
    li {
        margin-bottom: 10px;
    }
</style>
