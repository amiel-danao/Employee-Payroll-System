import time
import requests
import socket
import webbrowser
from pynput.mouse import Listener

def on_move(x, y):
    global moved
    moved = True

def get_local_ip():
    try:
        host_name = socket.gethostname()
        local_ip = socket.gethostbyname(host_name)
        return local_ip
    except socket.error as e:
        return f"Socket error: {e}"

while True:
    moved = False

    # Start monitoring cursor movement
    with Listener(on_move=on_move) as listener:
        time.sleep(60)  # Wait for 5 seconds
        listener.stop()  # Stop monitoring

    # If no movement detected, send POST request with local IP
    if not moved:
        local_ip = get_local_ip()
        if local_ip:
            endpoint = "http://127.0.0.1:8000/alert"
            data = {"ip": local_ip}
            url = "http://127.0.0.1:8000/alert"  # Replace with your URL
            webbrowser.open_new_tab(url)
        else:
            print("Failed to retrieve local IP")
