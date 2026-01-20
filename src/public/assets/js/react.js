/**
 * Handles user reactions (like/skip) on posts.
 */
class ReactionsManager {
    /**
     * Constructor
     * Initializes DOM references and starts the manager.
     */
    constructor() {
        this.skipBtn = document.querySelector('.skip-btn');
        this.likeBtn = document.querySelector('.like-btn');
        this.postsContainer = document.getElementById('posts-container');
        this.noPostsTemplate = document.getElementById('no-posts-template');
        this.init();
    }

    /**
     * init
     * Set up event listeners and keyboard support
     */
    init() {
        if (!this.skipBtn || !this.likeBtn) return;
        this.addEventListeners();
        this.setupKeyboardSupport();
    }

    /**
     * addEventListeners
     * Connects buttons to the reaction handler
     */
    addEventListeners() {
        [this.skipBtn, this.likeBtn].forEach(btn => {
            btn.addEventListener('click', () => {
                const type = btn.classList.contains('like-btn') ? 'like' : 'skip';
                this.handleReaction(btn.dataset.postId, type);
            });
        });
    }

    /**
     * handleReaction
     * Handles a user's reaction on a post
     * @param {number|string} postId - Current post ID
     * @param {'like'|'skip'} type - Reaction type
     */
    async handleReaction(postId, type) {
        const postCard = document.querySelector('.post-card .card');
        if (!postCard) return;

        this.setButtonsDisabled(true);

        // Swipe and fade out animation
        postCard.style.transition = 'all 0.3s ease';
        postCard.style.transform = type === 'like'
            ? 'translateX(100%) rotate(10deg)'
            : 'translateX(-100%) rotate(-10deg)';
        postCard.style.opacity = '0';

        // Wait for animation end, then update content
        postCard.addEventListener('transitionend', async () => {
            try {
                const data = await this.sendReactionToServer(postId, type);
                if (!data.success) throw new Error(data.error || 'Error');

                if (data.next_post) this.updatePost(data.next_post);
                else this.showNoPostsMessage();
            } catch (err) {
                this.showMessage('danger', err.message);
            } finally {
                this.setButtonsDisabled(false);
            }
        }, { once: true });
    }

    /**
     * sendReactionToServer
     * Sends the reaction to the server and returns the next post
     */
    async sendReactionToServer(postId, type) {
        const formData = new FormData();
        formData.append('post_id', postId);
        formData.append('type', type);
        const res = await fetch('react.php', { method: 'POST', body: formData });
        return res.json();
    }

    /**
     * updatePost
     * Updates the post content with new data
     */
    updatePost(post) {
        const postCard = document.querySelector('.post-card');
        if (!postCard) return;

        postCard.dataset.postId = post.id;
        postCard.querySelector('#post-title').textContent = post.title;
        postCard.querySelector('#post-user').textContent = '@' + post.user_username;
        postCard.querySelector('#post-content').textContent = post.content;
        postCard.querySelector('#post-course').textContent = post.degree_course || 'Not specified';
        postCard.querySelector('#post-team').textContent = post.num_collaborators;

        const skillsEl = postCard.querySelector('#post-skills');
        if (post.skills_required) {
            if (skillsEl) skillsEl.textContent = post.skills_required;
            else {
                const li = document.createElement('li');
                li.className = 'py-1';
                li.innerHTML = `<strong>Required skills:</strong> <span id="post-skills">${post.skills_required}</span>`;
                postCard.querySelector('.list-unstyled').appendChild(li);
            }
        } else if (skillsEl) skillsEl.parentElement.remove();

        // Reset animation
        const card = postCard.querySelector('.card');
        card.style.transition = '';
        card.style.transform = '';
        card.style.opacity = '1';

        // Update buttons
        this.skipBtn.dataset.postId = post.id;
        this.likeBtn.dataset.postId = post.id;
    }

    /**
     * showNoPostsMessage
     * Display the "no posts available" message
     */
    showNoPostsMessage() {
        this.postsContainer.innerHTML = '';
        if (this.noPostsTemplate) {
            this.postsContainer.appendChild(this.noPostsTemplate.content.cloneNode(true));
        }
        this.skipBtn.style.display = 'none';
        this.likeBtn.style.display = 'none';
    }

    /**
     * setButtonsDisabled
     * Enable or disable reaction buttons
     */
    setButtonsDisabled(disabled) {
        [this.skipBtn, this.likeBtn].forEach(btn => btn.disabled = disabled);
    }

    /**
     * showMessage
     * Show a temporary alert message
     */
    showMessage(type, text) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} position-fixed top-0 end-0 m-3`;
        alert.style.zIndex = '1050';
        alert.textContent = text;
        document.body.appendChild(alert);
        setTimeout(() => alert.remove(), 5000);
    }
}

document.addEventListener('DOMContentLoaded', () => new ReactionsManager());
