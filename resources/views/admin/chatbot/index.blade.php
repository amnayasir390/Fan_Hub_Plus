@extends('layouts.admin')
@section('title', 'Chatbot FAQs')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:0.75rem;">
    <p style="color:var(--text-secondary);font-size:0.875rem;">{{ $faqs->total() }} FAQ entries</p>
    <a href="{{ route('admin.chatbot.create') }}" class="btn btn-primary">+ Add FAQ</a>
</div>

<div class="card" style="overflow:auto;">
    <table class="admin-table">
        <thead>
            <tr><th>#</th><th>Question</th><th>Category</th><th>Active</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($faqs as $faq)
            <tr>
                <td style="color:var(--text-secondary);">{{ $faq->sort_order }}</td>
                <td style="max-width:300px;font-weight:600;">{{ Str::limit($faq->question, 60) }}</td>
                <td>{{ $faq->category ? '<span class="badge badge-gray">'.ucfirst($faq->category).'</span>' : '—' }}</td>
                <td>
                    <span class="badge {{ $faq->is_active ? 'badge-green' : 'badge-gray' }}">
                        {{ $faq->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:0.4rem;">
                        <a href="{{ route('admin.chatbot.edit', $faq->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.chatbot.destroy', $faq->id) }}" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this FAQ?')">Del</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:var(--text-secondary);padding:2rem;">No FAQs yet. Add some to power the chatbot!</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination">{{ $faqs->links('vendor.pagination.custom') }}</div>
@endsection
