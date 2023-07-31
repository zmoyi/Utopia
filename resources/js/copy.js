import ClipboardJS from "clipboard";
window.addEventListener('copyPrivateKay', evt => {
    const i = document.getElementById('data.private_key')
    ClipboardJS.copy(i.value)
    new Notification()
        .success()
        .title('已复制')
        .send()
})
