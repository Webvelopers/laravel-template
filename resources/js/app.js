const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')

const refreshButton = document.querySelector('[data-human-verification-refresh]')
const verificationImage = document.querySelector('[data-human-verification-image]')

if (csrfToken && refreshButton instanceof HTMLButtonElement && verificationImage instanceof HTMLImageElement) {
    refreshButton.addEventListener('click', async (event) => {
        event.preventDefault()

        refreshButton.disabled = true

        try {
            const response = await fetch(refreshButton.formAction, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({}),
            })

            if (!response.ok) {
                throw new Error('Refresh failed')
            }

            const payload = await response.json()

            if (typeof payload.image === 'string' && payload.image.length > 0) {
                verificationImage.src = payload.image
            }
        } catch {
            refreshButton.form?.submit()
        } finally {
            refreshButton.disabled = false
        }
    })
}
